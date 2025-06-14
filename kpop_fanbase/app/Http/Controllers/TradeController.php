<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\TradeItem;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index()
    {
        $items = TradeItem::with(['group', 'owner'])
            ->where('status', 'available')
            ->filter(request(['search', 'group_id']))
            ->latest()
            ->paginate(12);

        $groups = Group::all();

        return view('trades.index', compact('items', 'groups'));
    }

    public function create(Request $request)
    {
        $requestedItem = $request->has('item_id') 
            ? TradeItem::findOrFail($request->item_id)
            : null;

        $myItems = TradeItem::where('owner_id', auth()->id())
            ->where('status', 'available')
            ->get();

        $availableItems = TradeItem::where('status', 'available')
            ->where('owner_id', '!=', auth()->id())
            ->get();

        return view('trades.create', compact('requestedItem', 'myItems', 'availableItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'offered_item_id' => 'required|exists:trade_items,id',
            'requested_item_id' => 'required|exists:trade_items,id',
            'message' => 'nullable|string|max:500',
        ]);

        $offeredItem = TradeItem::find($validated['offered_item_id']);
        $requestedItem = TradeItem::find($validated['requested_item_id']);

        // Verificar se os itens pertencem ao usuário correto
        if ($offeredItem->owner_id !== auth()->id()) {
            return back()->with('error', 'Você não é o dono do item oferecido!');
        }

        if ($requestedItem->owner_id === auth()->id()) {
            return back()->with('error', 'Você não pode trocar um item consigo mesmo!');
        }

        // Criar a proposta de troca
        Trade::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $requestedItem->owner_id,
            'offered_item_id' => $offeredItem->id,
            'requested_item_id' => $requestedItem->id,
            'offered_item' => $offeredItem->name,
            'requested_item' => $requestedItem->name,
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return redirect()->route('trades.manage')->with('success', 'Proposta de troca enviada!');
    }

    public function show(TradeItem $item)
    {
        $item->load(['group', 'owner', 'tradeOffers.sender']);
        return view('trades.show', compact('item'));
    }

    public function manage()
    {
        $receivedTrades = Trade::with(['sender', 'offeredItem'])
            ->where('receiver_id', auth()->id())
            ->latest()
            ->get();

        $sentTrades = Trade::with(['receiver', 'requestedItem'])
            ->where('sender_id', auth()->id())
            ->latest()
            ->get();

        $completedTrades = Trade::with(['sender', 'receiver'])
            ->where(function($query) {
                $query->where('sender_id', auth()->id())
                    ->orWhere('receiver_id', auth()->id());
            })
            ->where('status', '!=', 'pending')
            ->latest()
            ->get();

        return view('trades.manage', compact('receivedTrades', 'sentTrades', 'completedTrades'));
    }

    public function accept(Trade $trade)
    {
        if ($trade->receiver_id !== auth()->id()) {
            abort(403);
        }

        \DB::transaction(function () use ($trade) {
            // Atualizar status da troca
            $trade->update(['status' => 'accepted']);

            // Transferir itens
            TradeItem::where('id', $trade->offered_item_id)
                ->update(['owner_id' => $trade->receiver_id]);

            TradeItem::where('id', $trade->requested_item_id)
                ->update(['owner_id' => $trade->sender_id]);

            // Marcar itens como trocados
            TradeItem::whereIn('id', [$trade->offered_item_id, $trade->requested_item_id])
                ->update(['status' => 'traded']);
        });

        return back()->with('success', 'Troca aceita e concluída!');
    }

    public function reject(Trade $trade)
    {
        if ($trade->receiver_id !== auth()->id()) {
            abort(403);
        }

        $trade->update(['status' => 'rejected']);
        return back()->with('success', 'Proposta de troca recusada!');
    }

    public function cancel(Trade $trade)
    {
        if ($trade->sender_id !== auth()->id()) {
            abort(403);
        }

        $trade->delete();
        return back()->with('success', 'Proposta de troca cancelada!');
    }

    public function destroy(TradeItem $item)
    {
        if ($item->owner_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();
        return redirect()->route('trades.index')->with('success', 'Item removido!');
    }
}
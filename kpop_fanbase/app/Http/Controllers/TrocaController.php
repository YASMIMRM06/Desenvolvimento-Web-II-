<?php

namespace App\Http\Controllers;

use App\Models\ItemColecionavel;
use App\Models\Troca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrocaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $trocasEnviadas = Auth::user()->trocasEnviadas()->with(['itemOfertante', 'itemDesejado', 'receptor'])->paginate(5);
        $trocasRecebidas = Auth::user()->trocasRecebidas()->with(['itemOfertante', 'itemDesejado', 'ofertante'])->paginate(5);
        
        return view('trocas.index', compact('trocasEnviadas', 'trocasRecebidas'));
    }

    public function create(ItemColecionavel $itemDesejado)
    {
        $this->authorize('create', [Troca::class, $itemDesejado]);

        $meusItens = Auth::user()->itensColecionaveis()
                        ->where('disponivel_para_troca', true)
                        ->where('id', '!=', $itemDesejado->id)
                        ->get();
                        
        return view('trocas.create', compact('itemDesejado', 'meusItens'));
    }

    public function store(Request $request, ItemColecionavel $itemDesejado)
    {
        $this->authorize('create', [Troca::class, $itemDesejado]);

        $request->validate([
            'item_ofertante_id' => 'required|exists:itens_colecionaveis,id',
            'mensagem' => 'nullable|string|max:500',
        ]);

        $itemOfertante = ItemColecionavel::findOrFail($request->item_ofertante_id);

        // Verifica se o item ofertante pertence ao usuário
        if ($itemOfertante->user_id !== Auth::id()) {
            abort(403, 'Você não é o dono deste item!');
        }

        // Verifica se o item ofertante está disponível para troca
        if (!$itemOfertante->disponivel_para_troca) {
            return back()->with('error', 'Este item não está disponível para troca!');
        }

        // Cria a proposta de troca
        Troca::create([
            'user_ofertante_id' => Auth::id(),
            'user_receptor_id' => $itemDesejado->user_id,
            'item_ofertante_id' => $itemOfertante->id,
            'item_desejado_id' => $itemDesejado->id,
            'status' => 'pendente',
            'mensagem' => $request->mensagem,
        ]);

        return redirect()->route('trocas.index')->with('success', 'Proposta de troca enviada com sucesso!');
    }

    public function show(Troca $troca)
    {
        $this->authorize('view', $troca);
        
        return view('trocas.show', compact('troca'));
    }

    public function aceitar(Troca $troca)
    {
        $this->authorize('aceitar', $troca);

        // Verifica se os itens ainda estão disponíveis
        if (!$troca->itemOfertante->disponivel_para_troca || !$troca->itemDesejado->disponivel_para_troca) {
            return back()->with('error', 'Um dos itens não está mais disponível para troca!');
        }

        // Atualiza o status da troca
        $troca->update([
            'status' => 'aceito',
            'data_conclusao' => now(),
        ]);

        // Atualiza os donos dos itens
        $troca->itemOfertante->update(['user_id' => $troca->user_receptor_id, 'disponivel_para_troca' => false]);
        $troca->itemDesejado->update(['user_id' => $troca->user_ofertante_id, 'disponivel_para_troca' => false]);

        // Cancela outras trocas envolvendo estes itens
        Troca::where(function($query) use ($troca) {
                $query->where('item_ofertante_id', $troca->item_ofertante_id)
                      ->orWhere('item_desejado_id', $troca->item_ofertante_id)
                      ->orWhere('item_ofertante_id', $troca->item_desejado_id)
                      ->orWhere('item_desejado_id', $troca->item_desejado_id);
            })
            ->where('id', '!=', $troca->id)
            ->where('status', 'pendente')
            ->update(['status' => 'cancelado']);

        return back()->with('success', 'Troca aceita com sucesso! Os itens foram transferidos.');
    }

    public function recusar(Troca $troca)
    {
        $this->authorize('recusar', $troca);

        $troca->update(['status' => 'recusado']);

        return back()->with('success', 'Troca recusada com sucesso!');
    }

    public function cancelar(Troca $troca)
    {
        $this->authorize('cancelar', $troca);

        $troca->update(['status' => 'cancelado']);

        return back()->with('success', 'Troca cancelada com sucesso!');
    }
}
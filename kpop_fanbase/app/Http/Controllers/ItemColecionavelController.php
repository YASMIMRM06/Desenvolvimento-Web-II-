<?php

namespace App\Http\Controllers;

use App\Models\ItemColecionavel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemColecionavelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $itens = Auth::user()->itensColecionaveis()->paginate(10);
        return view('itens.index', compact('itens'));
    }

    public function create()
    {
        return view('itens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'tipo' => 'required|in:album,photocard,merchandising,outro',
            'estado' => 'required|in:novo,seminovo,usado',
            'disponivel_para_troca' => 'required|boolean',
            'foto' => 'required|image|max:2048',
        ]);

        $path = $request->file('foto')->store('itens', 'public');

        ItemColecionavel::create([
            'user_id' => Auth::id(),
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo,
            'estado' => $request->estado,
            'disponivel_para_troca' => $request->disponivel_para_troca,
            'foto' => $path,
        ]);

        return redirect()->route('itens.index')->with('success', 'Item adicionado à sua coleção!');
    }

    public function show(ItemColecionavel $item)
    {
        $this->authorize('view', $item);
        return view('itens.show', compact('item'));
    }

    public function edit(ItemColecionavel $item)
    {
        $this->authorize('update', $item);
        return view('itens.edit', compact('item'));
    }

    public function update(Request $request, ItemColecionavel $item)
    {
        $this->authorize('update', $item);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'tipo' => 'required|in:album,photocard,merchandising,outro',
            'estado' => 'required|in:novo,seminovo,usado',
            'disponivel_para_troca' => 'required|boolean',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Remove a foto antiga
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            
            $path = $request->file('foto')->store('itens', 'public');
            $data['foto'] = $path;
        }

        $item->update($data);

        return redirect()->route('itens.show', $item)->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(ItemColecionavel $item)
    {
        $this->authorize('delete', $item);

        // Verifica se o item está em alguma troca pendente
        if ($item->trocasComoOfertante()->whereIn('status', ['pendente', 'aceito'])->exists() ||
            $item->trocasComoDesejado()->whereIn('status', ['pendente', 'aceito'])->exists()) {
            return back()->with('error', 'Não é possível excluir este item pois ele está envolvido em uma troca pendente!');
        }

        // Remove a foto associada
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return redirect()->route('itens.index')->with('success', 'Item removido da sua coleção!');
    }

    public function disponiveisParaTroca()
    {
        $itens = ItemColecionavel::where('disponivel_para_troca', true)
                    ->where('user_id', '!=', Auth::id())
                    ->with('dono')
                    ->paginate(10);
                    
        return view('itens.disponiveis', compact('itens'));
    }
}
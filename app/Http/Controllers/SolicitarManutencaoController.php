use App\Models\Modelo;

public function create()
{
    $modelos = Modelo::with('fabricante')->orderBy('nome')->get();
    return view('solicitar-manutencao', compact('modelos'));
}

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Processa o login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Valida os dados de login
        $credentials = $request->only('email', 'password');

        // Tenta autenticar o usuário
        if (Auth::attempt($credentials)) {
            // Autenticado com sucesso, redireciona para o dashboard
            return redirect()->route('dashboard');
        }

        // Se falhar, redireciona de volta com erro
        return back()->withErrors([
            'email' => 'Esses dados não coincidem com nossos registros.',
        ]);
    }
}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.dashboard');
    }

    public function kelas()
    {
        // Ambil data dari tabel program_kursus
        $programs = DB::table('program_kursus')->get();
        return view('student.kelas', compact('programs'));
    }

    public function profile()
    {
        return view('student.profile');
    }
}
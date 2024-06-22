namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $clienteRole = Role::create(['name' => 'Cliente']);
        $empleadoRole = Role::create(['name' => 'Empleado']);

        // Asignar roles a usuarios (suponiendo que tienes usuarios creados)
        $clienteUser = User::find(1); // ID del usuario cliente
        $empleadoUser = User::find(2); // ID del usuario empleado

        if ($clienteUser) {
            $clienteUser->assignRole($clienteRole);
        }

        if ($empleadoUser) {
            $empleadoUser->assignRole($empleadoRole);
        }
    }
}
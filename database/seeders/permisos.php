<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class permisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Gestión de Roles
       $permisosRoles = [
        'gestionar-roles-ver',
        'gestionar-roles-crear',
        'gestionar-roles-editar',
        'gestionar-roles-eliminar',
    ];

    // Gestión de Usuarios
    $permisosUsuarios = [
        'gestionar-usuarios-ver',
        'gestionar-usuarios-crear',
        'gestionar-usuarios-editar',
        'gestionar-usuarios-eliminar',
    ];

    // Crear permisos en la base de datos
    $categoriasPermisos = [
        $permisosRoles,
        $permisosUsuarios,

    ];

        foreach ($categoriasPermisos as $permisos) {
            foreach ($permisos as $permiso) {
                Permission::create(['name' => $permiso, 'guard_name' => 'web']);
            }
        }
    }
}

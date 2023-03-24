<?php

namespace App\Enums;

enum RoleAndPermissionsEnum: string
{
    // roles
    case Role_Admin = 'admin';

    // user permissions
    case Permission_User_Retrieve = 'retrieve user';
    case Permission_User_Create = 'create user';
    case Permission_User_Edit = 'edit user';
    case Permission_User_Delete = 'delete user';

    // data permissions
    case Permission_Data_Retrieve = 'retrieve data';
    case Permission_Data_Create = 'create data';
    case Permission_Data_Edit = 'edit data';
    case Permission_Data_Delete = 'delete data';
}

<?php

namespace App\Enums;

use phpDocumentor\Reflection\Types\Self_;

enum PermissionsEnum: string
{
    // Role Permissions
    case VIEW_ROLES = 'view_roles';
    case VIEW_ROLE = 'view_role';
    case DELETE_ROLE = 'delete_role';
    case UPDATE_ROLE = 'update_role';
    case CREATE_ROLE = 'create_role';

    // User Permissions
    case VIEW_USERS = 'view_users';
    case VIEW_USER = 'view_user';
    case CHANGE_USER_ROLES = 'change_user_roles';

    // page Permissions
    case TEACHER_VIEW = 'teacher_view';
    case STUDENT_VIEW = 'student_view';
    case ADMIN_VIEW = 'admin_view';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}

<?php

namespace App\Enums;

enum Permissions: string
{
    // Role Management Permissions
    case VIEW_ROLE = 'view-role';
    case CREATE_ROLE = 'create-role';
    case EDIT_ROLE = 'edit-role';
    case DELETE_ROLE = 'delete-role';

    // Admin User Management Permissions
    case VIEW_ADMIN_USER = 'view-admin-user';
    case CREATE_USER = 'create-user';
    case EDIT_USER = 'edit-user';
    case DELETE_USER = 'delete-user';
    case RESEND_USER_MAIL = 'resend-user-mail';

    // KYC Management Permissions
    case VIEW_KYC = 'view-kyc';
    case EDIT_KYC = 'edit-kyc';
    // case UNDER_REVIEW_KYC = 'under-review-kyc';
    // case APPROVE_KYC = 'approve-kyc';
    // case REJECT_KYC = 'reject-kyc';
}

<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\PaymentMethod;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentMethodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $admin)
    {
        return $admin->can('view_any_payment::method');
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, PaymentMethod $paymentMethod)
    {
        return $admin->can('view_payment::method');
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        return $admin->can('create_payment::method');
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin, PaymentMethod $paymentMethod)
    {
        return $admin->can('update_payment::method');
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin, PaymentMethod $paymentMethod)
    {
        return $admin->can('delete_payment::method');
    }

    /**
     * Determine whether the admin can bulk delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(Admin $admin)
    {
        return $admin->can('delete_any_payment::method');
    }

    /**
     * Determine whether the admin can permanently delete.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, PaymentMethod $paymentMethod)
    {
        return $admin->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(Admin $admin)
    {
        return $admin->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the admin can restore.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, PaymentMethod $paymentMethod)
    {
        return $admin->can('{{ Restore }}');
    }

    /**
     * Determine whether the admin can bulk restore.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(Admin $admin)
    {
        return $admin->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the admin can replicate.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(Admin $admin, PaymentMethod $paymentMethod)
    {
        return $admin->can('{{ Replicate }}');
    }

    /**
     * Determine whether the admin can reorder.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(Admin $admin)
    {
        return $admin->can('{{ Reorder }}');
    }

}

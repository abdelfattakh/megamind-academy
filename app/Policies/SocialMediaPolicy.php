<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\SocialMedia;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialMediaPolicy
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
        return $admin->can('view_any_social::media');
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, SocialMedia $socialMedia)
    {
        return $admin->can('view_social::media');
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin)
    {
        return $admin->can('create_social::media');
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin, SocialMedia $socialMedia)
    {
        return $admin->can('update_social::media');
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin, SocialMedia $socialMedia)
    {
        return $admin->can('delete_social::media');
    }

    /**
     * Determine whether the admin can bulk delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(Admin $admin)
    {
        return $admin->can('delete_any_social::media');
    }

    /**
     * Determine whether the admin can permanently delete.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, SocialMedia $socialMedia)
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
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, SocialMedia $socialMedia)
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
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(Admin $admin, SocialMedia $socialMedia)
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

<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\WorkshopEntry;
use App\Models\SessionEntry;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Carbon;

class WorkshopEntryPolicy
{
    use HandlesAuthorization;

    static string $modelPermission = 'workshop::entry';

    /**
     * Determine whether the admin can view any models.
     *
     * @param Admin $admin
     * @return Response|bool
     */
    public function viewAny(Admin $admin): Response|bool
    {
        return $admin->can("view_any_" . self::$modelPermission) || $admin->can("view_own_" . self::$modelPermission);
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param Admin $admin
     * @param WorkshopEntry $workshopEntry
     * @return Response|bool
     */
    public function view(Admin $admin, WorkshopEntry $workshopEntry): Response|bool
    {
        if ($admin->can("view_any_" . self::$modelPermission)) {
            return true;
        }

        if ($admin->can("view_own_" . self::$modelPermission)) {
            return $workshopEntry->instructor()->is($admin);
        }

        return false;
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param Admin $admin
     * @return Response|bool
     */
    public function create(Admin $admin): Response|bool
    {
        return $admin->can("create_" . self::$modelPermission) || $admin->can("create_own_" . self::$modelPermission);
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param Admin $admin
     * @param WorkshopEntry $workshopEntry
     * @return Response|bool
     */
    public function update(Admin $admin, WorkshopEntry $workshopEntry): Response|bool
    {
        if ($admin->can("update_any_" . self::$modelPermission)) {
            return true;
        }

        if ($admin->can("update_own_" . self::$modelPermission)) {
            return $workshopEntry->instructor()->is($admin);
        }

        return false;
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param Admin $admin
     * @param WorkshopEntry $workshopEntry
     * @return Response|bool
     */
    public function delete(Admin $admin, WorkshopEntry $workshopEntry): Response|bool
    {
        if ($admin->can("delete_any_" . self::$modelPermission)) {
            return true;
        }

        if ($admin->can("delete_own_" . self::$modelPermission)) {
            return $workshopEntry->instructor()->is($admin);
        }

        return false;
    }

    /**
     * Determine whether the admin can bulk delete.
     *
     * @param Admin $admin
     * @return Response|bool
     */
    public function deleteAny(Admin $admin): Response|bool
    {
        return $admin->can("delete_any_" . self::$modelPermission);
    }

    /**
     * Determine whether the admin can permanently delete.
     *
     * @param Admin $admin
     * @param WorkshopEntry $workshopEntry
     * @return Response|bool
     */
    public function forceDelete(Admin $admin, WorkshopEntry $workshopEntry): Response|bool
    {
        return $admin->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     *
     * @param Admin $admin
     * @return Response|bool
     */
    public function forceDeleteAny(Admin $admin): Response|bool
    {
        return $admin->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the admin can restore.
     *
     * @param Admin $admin
     * @param WorkshopEntry $workshopEntry
     * @return Response|bool
     */
    public function restore(Admin $admin, WorkshopEntry $workshopEntry): Response|bool
    {
        return $admin->can('{{ Restore }}');
    }

    /**
     * Determine whether the admin can bulk restore.
     *
     * @param Admin $admin
     * @return Response|bool
     */
    public function restoreAny(Admin $admin): Response|bool
    {
        return $admin->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the admin can replicate.
     *
     * @param Admin $admin
     * @param WorkshopEntry $workshopEntry
     * @return Response|bool
     */
    public function replicate(Admin $admin, WorkshopEntry $workshopEntry): Response|bool
    {
        return $admin->can('{{ Replicate }}');
    }

    /**
     * Determine whether the admin can reorder.
     *
     * @param Admin $admin
     * @return Response|bool
     */
    public function reorder(Admin $admin): Response|bool
    {
        return $admin->can('{{ Reorder }}');
    }

}

<?php

namespace App\Services\AdminPanel\User;

use App\DTO\User\UserFullInfoDTO;
use App\Models\Order;
use App\Models\User;

class UserService
{
    public function getPaginatedUsers(int $perPage)
    {
        return User::paginate($perPage);
    }

    public function getHeaderInfo()
    {
        $header = [];

        $totalUsers = User::count();

        // Кол-во пользователей, у которых есть хотя бы один заказ
        $activeUsers = Order::distinct('user_id')->count('user_id');

        $header['count'] = $totalUsers;

        $header['activeUserPercent'] = $totalUsers > 0
            ? round(($activeUsers / $totalUsers) * 100, 2)
            : 0;

        $highestOrderUserId = Order::orderByDesc('total_price')
            ->limit(1)
            ->value('user_id');

        $header['topSpendingUser'] = $highestOrderUserId
            ? User::find($highestOrderUserId)
            : null;

        $header['newUsers'] = User::where('created_at', '>=', now()->subDays(30))->count();
        return $header;
    }

    public function getUserFullInfo(User $user)
    {
        $orders = $user->orders()->latest()->get();
        $orders->totalPrice = number_format($orders->sum('total_price'));

        $userDTO = new UserFullInfoDTO(
            id: $user->id,
            name: $user->name,
            surname: $user->surname,
            email: $user->email,
            phone: $user->phone,
            address: $user->address,
            role: $user->role_label,
            orders: $orders,
            created_at: $user->created_at->translatedFormat('j F Yг. в H:i'),
            updated_at: $user->updated_at->translatedFormat('j F Yг. в H:i'),
            deleted_at: $user->deleted_at ? $user->deleted_at->translatedFormat('j F Yг. в H:i') : 'Не удален'

        );

        return $userDTO;
    }
}

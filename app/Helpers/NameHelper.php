<?php

namespace App\Helpers;

/**
 * NameHelper - Privacy Protection Utility
 *
 * Masks user names to protect privacy in buyer-seller communications.
 * Buyer sees: "Gabriel A" instead of "Gabriel Ahmed"
 * Seller sees: "John D" instead of "John Doe"
 * Admin sees: Full names for tracking purposes
 */
class NameHelper
{
    /**
     * Mask a user's full name to First Name + Last Initial
     *
     * Example: "Gabriel Ahmed" -> "Gabriel A"
     * Example: "John Doe" -> "John D"
     * Example: "Sarah" -> "Sarah"
     *
     * @param string|null $firstName
     * @param string|null $lastName
     * @return string
     */
    public static function maskName(?string $firstName, ?string $lastName): string
    {
        // If both names are empty, return default
        if (empty($firstName) && empty($lastName)) {
            return 'User';
        }

        $maskedName = trim($firstName ?? '');

        // Add last initial if last name exists
        if (!empty($lastName)) {
            $lastInitial = mb_strtoupper(mb_substr($lastName, 0, 1));
            $maskedName .= ' ' . $lastInitial;
        }

        return trim($maskedName);
    }

    /**
     * Get masked name from User model
     *
     * @param \App\Models\User|null $user
     * @return string
     */
    public static function getMaskedName($user): string
    {
        if (!$user) {
            return 'User';
        }

        return self::maskName($user->first_name, $user->last_name);
    }

    /**
     * Get full name (for admin use only)
     *
     * @param \App\Models\User|null $user
     * @return string
     */
    public static function getFullName($user): string
    {
        if (!$user) {
            return 'User';
        }

        $firstName = trim($user->first_name ?? '');
        $lastName = trim($user->last_name ?? '');

        return trim($firstName . ' ' . $lastName);
    }

    /**
     * Get masked name for notification context
     * Used when sending notifications to opposite party
     *
     * @param \App\Models\User|null $user The user whose name to mask
     * @param int $recipientRole The role of the recipient (0=buyer, 1=seller, 2=admin)
     * @return string
     */
    public static function getNameForRecipient($user, int $recipientRole): string
    {
        // Admin sees full names
        if ($recipientRole === 2) {
            return self::getFullName($user);
        }

        // Buyer/Seller see masked names
        return self::getMaskedName($user);
    }
}

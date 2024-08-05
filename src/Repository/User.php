<?php

namespace Review\Repository;

final class User
{
    /**
     * Summary of getUserDefault
     * Return WP_User Properties
     * ID
     * user_login
     * user_pass
     * user_nicename
     * user_email
     * user_url
     * user_registered
     * user_activation_key
     * user_status
     * display_name
     * @return \WP_User|false
     */
    public function getUserDefault() : \WP_User|false
    {
        return get_user_by('login', 'weslley');
    }
}

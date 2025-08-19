<?php
Class Helper {
    Public static function wy_create_verification_code() : int {
        return rand( '100000', '999999' );
    }

    public static function wy_create_user_login( $email ): string {
        return explode( '@', $email )[0] . rand( 1, 99 );
    }

    public static function wy_create_display_name( $full_name ): array {

        $display_name_parts = explode( ' ', $full_name );

        $first_name   = $display_name_parts[0] ?? '';
        $last_name    = $display_name_parts[1] ?? '';
        $display_name = trim( $first_name . ' ' . $last_name );

        return [
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'display_name' => $display_name
        ];
    }

    public static function wy_create_token( $email ): string {
        $token = date('Ymd') . md5( $email ) . rand( 10000000, 99999999 );
        $token_url = site_url('password-recovery') . '?recovery_token=' . $token;
        return $token_url;
    }

}
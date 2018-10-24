<?php

return [
    "auth" => true,

    /**
     * Firebase Configs
     * */

    "admin_config_json_path" => resource_path("firebase-admin.json"),
    "login_check_time_duration" => 600, //With second


    /**
     * Base64 Image validator
     * */

    "allowed_types" => ['png', 'jpg', 'svg', "jpeg"],

    /**
     * Image resize configs
     * */
    "image_output_folder" => "/media/images/"


];

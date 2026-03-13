<?php

require_api( 'crypto_api.php' );

/**
 * Lightbox Integration
 * Copyright (C) Karim Ratib (karim@meedan.com)
 *
 * Lightbox Integration is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.
 *
 * Lightbox Integration is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Lightbox Integration; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
 * or see http://www.gnu.org/licenses/.
 */
 
class LightboxPlugin extends MantisPlugin {

    function register() {
        $this->name        = plugin_lang_get( 'title' );
        $this->description = plugin_lang_get( 'description' );
        $this->version     = '1.1.1';
        $this->page        = 'config_page';
        $this->requires    = array(
            'MantisCore' => '2.28.0',
        );
        $this->author  = 'T. K. (angepasst)';
        $this->contact = 'info@daytradertools.de';
        $this->url     = 'http://daytradertools.de';

        # Nonce für Inline-Scripts (CSP)
        $this->nonce   = crypto_generate_uri_safe_nonce( 16 );
    }

    /**
     * Default plugin configuration.
     */
    function config() {
        return array(
            'display_on_img_preview' => ON,
            'display_on_img_link'    => ON,
        );
    }

    /**
     * Registrierte Hooks
     */
    function hooks() {
        return array(
            'EVENT_LAYOUT_RESOURCES' => 'add_lightbox',
            'EVENT_CORE_HEADERS'     => 'csp_headers',
        );
    }

    /**
     * Ressourcen (CSS/JS) für Lightbox hinzufügen.
     * Wird auf jeder Seite eingebunden, aber das JS selbst
     * filtert auf passende Links (file_download.php).
     */
    function add_lightbox( $p_event ) {
        $t_lightbox_display_on_img_preview = plugin_config_get( 'display_on_img_preview' );
        $t_lightbox_display_on_img_link    = plugin_config_get( 'display_on_img_link' );

        $t_lightbox_js   = plugin_file( 'lightbox/js/lightbox.min.js' );
        $t_lightbox_css  = plugin_file( 'lightbox/css/lightbox.min.css' );
        $t_mantis_js     = plugin_file( 'Lightbox.js' );

        $t_images = array(
            'prev'    => plugin_file( 'lightbox/img/prev.png' ),
            'next'    => plugin_file( 'lightbox/img/next.png' ),
            'close'   => plugin_file( 'lightbox/img/close.png' ),
            'loading' => plugin_file( 'lightbox/img/loading.gif' ),
        );

        $t_nonce = $this->nonce;

        return <<<LIGHTBOX

<link rel="stylesheet" type="text/css" href="{$t_lightbox_css}" />

<script type="text/javascript" src="{$t_lightbox_js}"></script>
<script type="text/javascript" src="{$t_mantis_js}"></script>

<style type="text/css">
    .lb-nav a.lb-prev {
        background-image: url({$t_images['prev']});
    }
    .lb-nav a.lb-next {
        background-image: url({$t_images['next']});
    }
    .lb-data .lb-close {
        background-image: url({$t_images['close']});
    }
    .lb-cancel {
        background-image: url({$t_images['loading']});
    }
</style>
LIGHTBOX;
    }

    
    function csp_headers() {
        //Removed
    }
}

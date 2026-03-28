<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package   theme_ilb
 * @copyright 2016 Ryan Wyllie
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    // Bloco Acesso
    $settings->add(new admin_setting_heading('theme_ilb/heading_acesso', 'Bloco de acesso', 'Links do bloco de acesso'));
    // Signup url
    $setting = new admin_setting_configtext(
        "theme_ilb/signup",
        "URL para página de cadastro",
        "Entre a URL para a página de cadastro de novos usuários",
        "login/signup.php",
        PARAM_TEXT,
        100
    );
    $settings->add($setting);
    // Forgot password url
    $setting = new admin_setting_configtext(
        "theme_ilb/forgotpwd",
        "URL para página de recuperação de senha",
        "Entre a URL para a página de recuperação de senha",
        "login/forgot_password.php",
        PARAM_TEXT,
        100
    );
    $settings->add($setting);
        
    // Destaque
    $settings->add(new admin_setting_heading('theme_ilb/heading_destaque', 'Destaque', ''));
    // Habilitar destaque
    $setting = new admin_setting_configcheckbox('theme_ilb/habilitar_destaque',
        'Habilitar destaque',
        'Indica se deve ser exibido destaque na página inicial', 0);
    $settings->add($setting);
    // Curso de destaque
    $setting = new admin_setting_configtext('theme_ilb/curso_destaque',
    'Curso de destaque',
    'ID do curso acessado ao clicar na imagem de destaque', '', PARAM_TEXT, 4);
    $settings->add($setting);
    // URL de destque
    $setting = new admin_setting_configtext(
        "theme_ilb/url_destaque",
        "URL de destaque",
        "Uma URL externa para ser acessada ao clicar na imagem de destaque ao invés do curso. Esta URL tem precedência sobre o campo Curso de destaque.",
        "",
        PARAM_TEXT,
        100
    );
    $settings->add($setting);
    // Imagem destaque
    $setting = new admin_setting_configstoredfile('theme_ilb/imagem_destaque',
        'Imagem de destaque',
        'Imagem a ser exibida como destaque',
        'imagem_destaque',
        0,
        ["accepted_types" => [".png", ".jpg"]]);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
    // Qual imagem usar
    $setting = new admin_setting_configcheckbox(
        "theme_ilb/use_course_image",
        "Usar imagem do curso",
        "Se marcado, a imagem de capa do curso será usada no destaque",
        "0");
    $settings->add($setting);
    // Vídeo institucional
    $setting = new admin_setting_configtext(
        "theme_ilb/video_institucional",
        "Vídeo institucional",
        "Entre a URL de um vídeo institucional para ser mostrado na linha de destaque,",
        "https://www.youtube.com/embed/mvqFvkBF0PE",
        PARAM_TEXT,
        100
    );
    $settings->add($setting);

    // Linha de marqueting
    $settings->add(new admin_setting_heading('theme_ilb/heading_marquet', 'Marqueting', ''));
    // Posição da linha
    $setting = new admin_setting_configselect(
        "theme_ilb/posicao_marquet",
        "Posição da linha de marqueting",
        "Indique se a linha de marqueting deve aparecer, e se antes ou depois da caixa de destaques",
        0,
        [0 => "Não mostrar a linha de marqueting",
         1 => "Acima da linha de destaque",
         2 => "Abaixo da linha de destaque"]);
    $settings->add($setting);
    // linha de marqueting
    $setting = new admin_setting_confightmleditor(
        'theme_ilb/linha_marquet',
        'Linha de marqueting',
        'trecho de HTML que que será renderizado na página inicial logo antes ou após a linha de destaques',
        '',
        PARAM_RAW);
    $settings->add($setting);
}

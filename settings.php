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
    $settings = new theme_ilb_admin_settingspage_tabs('themesettingilb', "ILB");
    
    // Bloco Acesso -----------------------------------------------------------
    $page = new admin_settingpage('theme_ilb_acesso', 'Bloco de acesso');
    // Signup url
    $page->add(new admin_setting_configtext(
        "theme_ilb/signup",
        "URL para página de cadastro",
        "Entre a URL para a página de cadastro de novos usuários",
        "login/signup.php",
        PARAM_TEXT,
        100
    ));
    // Forgot password url
    $page->add(new admin_setting_configtext(
        "theme_ilb/forgotpwd",
        "URL para página de recuperação de senha",
        "Entre a URL para a página de recuperação de senha",
        "login/forgot_password.php",
        PARAM_TEXT,
        100
    ));
    $settings->add($page);

    // Destaque ---------------------------------------------------------------
    $page = new admin_settingpage('theme_ilb_destaque', 'Destaque');
    // Habilitar destaque
    $page->add(new admin_setting_configcheckbox(
        'theme_ilb/habilitar_destaque',
        'Habilitar destaque',
        'Indica se deve ser exibido destaque na página inicial', 0
    ));
    // Curso de destaque
    $page->add(new admin_setting_configtext(
        'theme_ilb/curso_destaque',
        'Curso de destaque',
        'ID do curso acessado ao clicar na imagem de destaque',
        '',
        PARAM_TEXT,
        4
    ));
    // URL de destque
    $page->add(new admin_setting_configtext(
        "theme_ilb/url_destaque",
        "URL de destaque",
        "Uma URL externa para ser acessada ao clicar na imagem de destaque ao invés do curso. Esta URL tem precedência sobre o campo Curso de destaque.",
        "",
        PARAM_TEXT,
        100
    ));
    // Imagem destaque
    $setting = new admin_setting_configstoredfile('theme_ilb/imagem_destaque',
        'Imagem de destaque',
        'Imagem a ser exibida como destaque',
        'imagem_destaque',
        0,
        ["accepted_types" => [".png", ".jpg"]]
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Qual imagem usar
    $page->add(new admin_setting_configcheckbox(
        "theme_ilb/use_course_image",
        "Usar imagem do curso",
        "Se marcado, a imagem de capa do curso será usada no destaque",
        "0"
    ));
    // Vídeo institucional
    $page->add(new admin_setting_configtext(
        "theme_ilb/video_institucional",
        "Vídeo institucional",
        "Entre a URL de um vídeo institucional para ser mostrado na linha de destaque,",
        "https://www.youtube.com/embed/mvqFvkBF0PE",
        PARAM_TEXT,
        100
    ));
    $settings->add($page);

    // Linha de marqueting ----------------------------------------------------
    $page = new admin_settingpage('theme_ilb_marquet', 'Marqueting');
    // Posição da linha
    $page->add(new admin_setting_configselect(
        "theme_ilb/posicao_marquet",
        "Posição da linha de marqueting",
        "Indique se a linha de marqueting deve aparecer, e se antes ou depois da caixa de destaques",
        0,
        [0 => "Não mostrar a linha de marqueting",
         1 => "Acima da linha de destaque",
         2 => "Abaixo da linha de destaque"]
    ));
    // linha de marqueting
    $page->add(new admin_setting_confightmleditor(
        'theme_ilb/linha_marquet',
        'Linha de marqueting',
        'trecho de HTML que que será renderizado na página inicial logo antes ou após a linha de destaques',
        '',
        PARAM_RAW
    ));
    $settings->add($page);

    // Aba certificados -------------------------------------------------------
    $page = new admin_settingpage('theme_ilb_certif', 'Aba de certificados');
    // bloco de validar certificados
    $page->add(new admin_setting_configcheckbox(
        "theme_ilb/hide_validador",
        "Ocultar o bloco de validar certificados",
        "",
        "0"
    ));
    // bloco de obter certificados
    $page->add(new admin_setting_configcheckbox(
        "theme_ilb/hide_obter",
        "Ocultar o bloco de obter certificados",
        "",
        "0"
    ));
    // bloco certificados antigos
    $page->add(new admin_setting_configcheckbox(
        "theme_ilb/hide_antigos",
        "Ocultar o bloco de obter certificados antigos",
        "",
        "0"
    ));
    // texto do bloco de certificados antigos
    $page->add(new admin_setting_configtextarea(
        'theme_ilb/texto_antigos',
        'Texto dos certificados antigos',
        'Pequeno texto explicativo para o bloco de certificados antigos',
        'Emissão de certificados para alunos inscritos no período de 2010/2013.',
        PARAM_TEXT,
        '40',
        '5'
    ));
    // Link para obter certificados antigos
    $page->add(new admin_setting_configtext(
        'theme_ilb/link_antigos',
        'Link certificados antigos',
        'Link para obter certificados antigos',
        'http://www17.senado.gov.br/user/login',
        PARAM_TEXT,
        100
    ));
    $settings->add($page);

    // Dados para contato -----------------------------------------------------
    $page = new admin_settingpage('theme_ilb_contato', 'Aba de contato');
    // Nome do serviço
    $page->add(new admin_setting_configtext(
        'theme_ilb/servico',
        'Serviço',
        'Nome do serviço do ILB para contato',
        'Serviço de Ensino a Distância – SEED',
        PARAM_TEXT,
        100
    ));
    // Telefone
    $page->add(new admin_setting_configtext(
        'theme_ilb/telefone',
        'Telefone',
        '',
        '+55 (61) 3303-1475',
        PARAM_TEXT,
        30
    ));
    // Email
    $page->add(new admin_setting_configtext(
        'theme_ilb/email',
        'E-mail',
        '',
        'ilbead@senado.leg.br',
        PARAM_TEXT,
        50
    ));
    // redes sociais
    $page->add(new admin_setting_confightmleditor(
        'theme_ilb/redes_sociais',
        'Redes sociais',
        'Use o editor hTML para apresentar os links das redes sociais do ILB',
        '<p style="font-weight:bold;">Facebook</p>
         <p><a href="https://www.facebook.com/ilbsenado">https://www.facebook.com/ilbsenado</a></p>',
        PARAM_RAW
    ));
    $settings->add($page);

    // FAQ - perguntas e respostas --------------------------------------------
    $page = new admin_settingpage('theme_ilb_faq', 'FAQ - Perguntas e respostas');
    $page->add(new admin_setting_configtext(
        'theme_ilb/num_perguntas',
        'Número de perguntas e respostas',
        'Quantas perguntas/respostas deseja criar?<br/><strong>Obs:</strong> Após mudar este valor, salve as mudanças para acessar o espaço para cadastrar as perguntas/respostas',
        0,
        PARAM_INT,
        5
    ));

    $num_perguntas = get_config("theme_ilb", "num_perguntas");
    if ($num_perguntas) {
        for ($pergunta = 1; $pergunta <= $num_perguntas; $pergunta++) {
            $page->add(new admin_setting_configtext(
                "theme_ilb/pergunta".$pergunta,
                "Pergunta ".$pergunta,
                "Texto da pergunta",
                "",
                PARAM_TEXT,
                100
            ));
            $page->add(new admin_setting_confightmleditor(
                'theme_ilb/resposta'.$pergunta,
                'Resposta '.$pergunta,
                'Resposta da pergunta',
                '',
                PARAM_RAW
            ));
        }
    }
    $settings->add($page);
}

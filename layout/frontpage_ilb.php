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
 * A one column layout for the ilb theme.
 *
 * @package   theme_ilb
 * @copyright 2016 Damyon Wiese
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/../config.php');

$bodyattributes = $OUTPUT->body_attributes([]);


$habilitar_destaque = $this->page->theme->settings->habilitar_destaque;
$curso_destaque = $this->page->theme->settings->curso_destaque;
$url_destaque = $this->page->theme->settings->url_destaque;
$imagem_destaque = $this->page->theme->settings->imagem_destaque;
$use_course_image = $this->page->theme->settings->use_course_image;
$linha_marquet = format_text($this->page->theme->settings->linha_marquet, FORMAT_HTML);
$video_institucional = $this->page->theme->settings->video_institucional;
$signup = $this->page->theme->settings->signup;
$forgotpwd = $this->page->theme->settings->forgotpwd;
$course = get_course($curso_destaque);

if (!$video_institucional) {
	$video_institucional = "https://www.youtube.com/embed/mvqFvkBF0PE";
}

if (!$signup) {
	$signup = "login/signup.php";
}
if (!$forgotpwd) {
	$forgotpwd = "login/forgot_password.php";
}
if ($imagem_destaque) {
	$imagem_destaque = $this->page->theme->setting_file_url('imagem_destaque', 'imagem_destaque');
}

if ($course) {
	$courseurl = (new moodle_url('/course/view.php', ['id' => $course->id]))->out(false);
} else {
	$courseurl = null;
}

if (!$url_destaque) {
	$url_destaque = $courseurl;
}

if ($use_course_image == 1 and $curso_destaque) {
	if ($imagem_curso = \core_course\external\course_summary_exporter::get_course_image($course)) {
		$imagem_destaque = $imagem_curso;
	}
}

switch ($this->page->theme->settings->posicao_marquet) {
	case 1: # Mostrar na parte superior
		$marquet_superior = true;
		$marquet_inferior = false;
		break;
	case 2: # mostrar na parte inferior
		$marquet_superior = false;
		$marquet_inferior = true;
		break;
	case 0: # Não mostrar em nenhum lugar
	default:
		$marquet_superior = false;
		$marquet_inferior = false;
		break;
};

$templatecontext = [
	'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
	'output' => $OUTPUT,
	'projetos_especiais' => $OUTPUT->image_url('projetos_especiais', 'theme'),
	'conheca-senado' => $OUTPUT->image_url('conheca-senado', 'theme'),
	'Cursos-on-line-sem-tutor' => $OUTPUT->image_url('Cursos-on-line-sem-tutor', 'theme'),
	'Cursos-on-line' => $OUTPUT->image_url('Cursos-on-line', 'theme'),
	'formacao_interna' => $OUTPUT->image_url('formacao_interna', 'theme'),
	'oficinas-interlegis' => $OUTPUT->image_url('oficinas-interlegis', 'theme'),
	'pos-graduacao' => $OUTPUT->image_url('pos-graduacao', 'theme'),
	'video-aula' => $OUTPUT->image_url('video-aula', 'theme'),
	'icon_ContatoEmail-azul' => $OUTPUT->image_url('icon_ContatoEmail-azul', 'theme'),
	'icon_ContatoFone-azul' => $OUTPUT->image_url('icon_ContatoFone-azul', 'theme'),
	'fundo-c' => $OUTPUT->image_url('fundo-c', 'theme'),
	'logo_saberes_xl' => $OUTPUT->image_url('logo_saberes_xl', 'theme'),
	'bodyattributes' => $bodyattributes,
	'moodle_url' => $CFG->wwwroot,
	'habilitar_destaque' => $habilitar_destaque,
	'imagem_destaque' => $imagem_destaque,
	'url_destaque' => $url_destaque,
	'video_institucional' => $video_institucional,
	'marquet_superior' => $marquet_superior,
	'marquet_inferior' => $marquet_inferior,
	'linha_marquet' => $linha_marquet,
	'signup' => $signup,
	'forgot-password' => $forgotpwd
];

if (isloggedin()) {
	user_preference_allow_ajax_update('drawer-open-nav', PARAM_ALPHA);
	require_once($CFG->libdir . '/behat/lib.php');

  	$navdraweropen = (get_user_preferences('drawer-open-nav', 'true') == 'true');
	$extraclasses = [];
	if ($navdraweropen) {
	    $extraclasses[] = 'drawer-open-left';
	}

	$blockshtml = $OUTPUT->blocks('side-pre');
	$hasblocks = strpos($blockshtml, 'data-block=') !== false;
	$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();

	global $USER,$PAGE;
  	$user_picture=new user_picture($USER);
  	$user_picture_url=$user_picture->get_url($PAGE);
  	$user_profile_url=$CFG->wwwroot . "/user/profile.php?id=" . $USER->id . "&course=1";

  	$templatecontext = [
	   	'sidepreblocks' => $blockshtml,
 		'hasblocks' => $hasblocks,
	    'CursosOnlineSemTutoria' => $OUTPUT->image_url('Cursos-on-line-sem-tutor', 'theme'),
	  	'navdraweropen' => $navdraweropen,
	  	'regionmainsettingsmenu' => $regionmainsettingsmenu,
	  	'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
		'username' => $USER->username,
		'firstname' => $USER->firstname,
		'lastname' => $USER->lastname,
		'sessKey' => $USER->sesskey,
		'loginChangeNotification' => false,
		'userpictureurl' => $user_picture_url,
		'userprofileurl' => $user_profile_url,
	] + $templatecontext;
} else {
	$templatecontext = [
	    'logintoken' => s(\core\session\manager::get_login_token())
	] + $templatecontext;
}

$templatecontext['flatnavigation'] = $PAGE->flatnav;
echo $OUTPUT->render_from_template('theme_ilb/frontpage_ilb', $templatecontext);

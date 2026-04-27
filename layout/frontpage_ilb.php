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


$modo_destaque = $this->page->theme->settings->modo_destaque ?: 'banner';
$curso_destaque = $this->page->theme->settings->curso_destaque;
$url_destaque = $this->page->theme->settings->url_destaque;
$url_destaque_label = $this->page->theme->settings->url_destaque_label ?: 'Saiba mais';
$url_destaque_target = $this->page->theme->settings->url_destaque_target;
$imagem_destaque = $this->page->theme->settings->imagem_destaque;
$use_course_image = $this->page->theme->settings->use_course_image;
$video_destaque = $this->page->theme->settings->video_destaque;
$linha_marquet = format_text($this->page->theme->settings->linha_marquet, FORMAT_HTML);
$video_institucional = $this->page->theme->settings->video_institucional ?: "https://www.youtube.com/embed/mvqFvkBF0PE";
$signup = $this->page->theme->settings->signup ?: "login/signup.php";
$forgotpwd = $this->page->theme->settings->forgotpwd ?: "login/forgot_password.php";
$rememberusername_label = $this->page->theme->settings->rememberusername_label ?: "Lembrar meu usuário";
$servico = $this->page->theme->settings->servico ?: "Serviço de Ensino a Distância – SEED";
$telefone = $this->page->theme->settings->telefone ?: "+55 (61) 3303-1475";
$email = $this->page->theme->settings->email ?: "ilbead@senado.leg.br";
$redes_sociais = $this->page->theme->settings->redes_sociais ?: '<p style="font-weight:bold;">Facebook</p><p><a href="https://www.facebook.com/ilbsenado">https://www.facebook.com/ilbsenado</a></p>';
$num_perguntas = $this->page->theme->settings->num_perguntas;
$num_categorias = $this->page->theme->settings->num_categorias;

try {
	$course = get_course($curso_destaque);
	$courseurl = (new moodle_url('/course/view.php', ['id' => $course->id]))->out(false);
} catch (Exception $e) {
	$courseurl = null;
}

if ($imagem_destaque) {
	$imagem_destaque = $this->page->theme->setting_file_url('imagem_destaque', 'imagem_destaque');
}

if (!$url_destaque or $modo_destaque == 'curso') {
	$url_destaque = $courseurl;
}

if ($use_course_image == 1 and $course) {
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

if ($num_perguntas) {
	$faq = [];
	$count = 0;
	for ($pergunta = 1; $pergunta <= $num_perguntas; $pergunta++) {
		$questao = $this->page->theme->settings->{"pergunta".$pergunta};
		$resposta = $this->page->theme->settings->{"resposta".$pergunta};
		if ($questao != "" && $resposta != "") {
			$count++;
			$faq[] = [
				"indice" => $count,
				"pergunta" => $questao,
				"resposta" => format_text($resposta, FORMAT_HTML),
			];
		}
	}
};

if ($num_categorias) {
	$context = context_system::instance();
	$categorias = [];
	$count = 0;
	for ($categoria = 1; $categoria <= $num_categorias; $categoria++) {
		$icon_url = moodle_url::make_pluginfile_url(
			$context->id,
			"theme_ilb",
			'icones_categoria',
			0,
			"/",
			$this->page->theme->settings->{"icone_categoria{$categoria}"}			
		);
		$url = $this->page->theme->settings->{"categoria{$categoria}"};
		$desc_categoria = $this->page->theme->settings->{"desc_categoria{$categoria}"};
		if ($url != "" && $desc_categoria != "") {
			$count++;
			$categorias[] = [
				"indice" => $count,
				"categoria" => $url,
				"desc_categoria" => $desc_categoria,
				"icone_categoria" => $icon_url,
				"quebra" => ($count % 4 == 0) && ($categoria < $num_categorias)
			];
		}
	}
}

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
	'destaque_banner' => $modo_destaque == 'banner',
	'destaque_curso' => $modo_destaque == 'curso' || $modo_destaque == 'link',
	'destaque_video' => $modo_destaque == 'video',
	'imagem_destaque' => $imagem_destaque,
	'video_destaque' => $video_destaque,
	'url_destaque' => $url_destaque,
	'url_destaque_label' => $url_destaque_label,
	'url_destaque_target' => $url_destaque_target,
	'video_institucional' => $video_institucional,
	'marquet_superior' => $marquet_superior,
	'marquet_inferior' => $marquet_inferior,
	'linha_marquet' => $linha_marquet,
	'signup' => $signup,
	'forgot-password' => $forgotpwd,
	'rememberusername_label' => $rememberusername_label,
	'hide_validador' => $this->page->theme->settings->hide_validador,
	'hide_obter' => $this->page->theme->settings->hide_obter,
	'hide_antigos' => $this->page->theme->settings->hide_antigos,
	'texto_antigos' => $this->page->theme->settings->texto_antigos ?: 'Emissão de certificados para alunos inscritos no período de 2010/2013.',
	'link_antigos' => $this->page->theme->settings->link_antigos ?: 'http://www17.senado.gov.br/user/login',
	'servico' => $servico,
	'telefone' => $telefone,
	'email' => $email,
	'redes_sociais' => format_text($redes_sociais, FORMAT_HTML),
	'tem_faq' => !empty($faq),
	'faq' => $faq,
	'tem_categorias' => !empty($categorias),
	'categorias' => $categorias
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

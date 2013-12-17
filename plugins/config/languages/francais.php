<?php

require_once (FS_PATH . "plugins/config/languages/default.php");

$lang['config_all_dependencies_found'] = "Toutes les d�pendances ont �t� trouv�es.";
$lang['config_bad'] = "indisponible";
$lang['config_button_config'] = "Passer � la configuration";
$lang['config_can_be_found'] = '%1$s peut �tre t�l�charg� � %2$s';
$lang['config_click_config'] = 'Cliquez %1$sici%2$s pour effectuer ou modifier votre configuration syst�me.';
$lang['config_click_cron'] = 'Cliquez %1$sici%2$s pour des instructions concernant la configuration du cronjob ou de la t�che p�riodique.';
$lang['config_click_db'] = 'Cliquez %1$sici%2$s pour configurer la base de donn�es.';
$lang['config_click_gentables'] = 'G�n�rer le script MySQL';
$lang['config_click_seats'] = 'Cliquez %1$sici%2$s pour cr�er ou modifier des plans de salles.';
$lang['config_click_spectacles'] = 'Cliquez %1$sici%2$s pour cr�er ou modifier des spectacles.';
$lang['config_config'] = "Configuration syst�me";
$lang['config_congratulations'] = "F�licitations";
$lang['config_cron'] = "Configuration du cronjob";
$lang['config_cron_latest'] = "Le cronjob a �t� ex�cut� pour la derni�re fois le";
$lang['config_cron_never'] = "Le cronjob n'a encore jamais �t� ex�cut�.";
$lang['config_db'] = "Base de donn�es";
$lang['config_db_adminpass'] = 'Choisissez un mot de passe pour l\'utilisateur administrateur';
$lang['config_db_systempass'] = 'Choisissez un mot de passe pour l\'utilisateur syst�me';
$lang['config_db_warning'] = <<<EOD
Attention, apr�s un clic sur ce bouton, vos mots de passe risquent d'�tre
affich�s en clair dans votre browser.
EOD;
$lang['config_dbtables'] = "Base de donn�es";
$lang['config_fplink'] = "Assistant d'installation FreeSeat et configuration syst�me";
$lang['config_good'] = "disponible";
$lang["config_group_configuration"] = 'Configuration';
$lang["config_group_configuration_msg"] = "Plugins utiles pour la configuration de FreeSeat. Assurez-vous qu'ils soient tous s�lectionn�s lors de l'installation de l'application. Vous pourrez en d�-s�lectionner plus tard.";
$lang['config_group_operator'] = 'Operateur';
$lang['config_group_operator_msg'] = "Facilite la vie de l'op�rateur";
$lang['config_group_payment'] = 'Paiement';
$lang['config_group_payment_msg'] = "Fournit d'autres moyens de paiement.";
$lang['config_group_tickets'] = 'Billets';
$lang['config_group_tickets_msg'] = "Personnalise l'apparence des billets.";
$lang['config_group_user'] = 'Utilisateur';
$lang['config_group_user_msg'] = "Fonctionnalit�s utilies pour l'acheteur.";
$lang['config_group_pricing'] = 'Prix';
$lang['config_group_pricing_msg'] = "Permet de modifier le calcul du prix, par exemples par taxes supl�mentaires ou offres sp�ciales.";
$lang['config_index'] = "la page principale de l'assistant";
$lang['config_intro'] = "Bienvenue � FreeSeat! Cet assistant va vous aider � installer et configurer FreeSeat.";
$lang['config_intro_congratulations'] = <<<EOD
Votre installation de FreeSeat est � pr�sent termin�e. Vous pouvez
maintenant d�sactiver les plugins de configuration par le lien
configuration syst�me ci-dessus. Ils pourront �tre r�activ�s � tout
moment en visitant cette page.
EOD;
$lang['config_intro_cron'] = <<<EOD
<p>Si vous ne l'avez pas encore fait, assurez-vous que <tt>cron.php</tt> soit ex�cut� une fois par jour apr�s minuit. Sur la plupart des syst�mes linux, il vous faut ajouter la ligne suivante � votre fichier <tt>crontab</tt>, �ventuellement apr�s adaptation&nbsp;:</p>
EOD;
$lang['config_intro_plugins'] = <<<EOD
<p>Veuillez s�lectionner les fonctionalit�s ("plugins") 
souhait�es pour votre installation FreeSeat.</p>

<p>Vous pourrez revenir ici � tout moment pour modifier votre s�lection si n�cessaire.</p>
EOD;
$lang['config_intro_genconfig'] = <<<EOD
  <p>Pour des raisons de s�curit�, FreeSeat n'est pas autoris� �
  modifier son propre fichier de configuration.</p>
<p>Veuillez enregistrer le fichier suivant sous le
nom <code>config.php</code> dans le r�pertoire racine de votre
installation FreeSeat : %1\$sconfig.php%2\$s.</p>
EOD;
$lang['config_intro_gentables'] = <<<EOD
<p>Pour des raisons de s�curit�, FreeSeat n'est pas autoris� � modifier
ou cr�er son propre sch�ma de base de donn�es.</p>
<p>Veuillez ex�cuter le script MySQL suivant (essayez un clic droit dans la
bo�te puis "Tout s�lectionner") � une invite MySQL en tant que root,
ou un utilisateur autoris� � cr�er et modifier des utilisateurs, des
bases de donn�es et des tables.</p>
EOD;
$lang['config_logged'] = 'et vous �tes connect�';
$lang['config_logged_but_no_db'] = 'Vous �tes connect� mais la base de donn�e doit encore �tre configur�e.';
$lang['config_need_syspass'] = "Veuillez �galement introduire votre mot de passe <em>syst�me</em> pour la v�rification de votre configuration&nbsp;:";
$lang['config_missing_dependencies'] = "Certaines d�pendances n'ont pas pu �tre trouv�es";
$lang['config_missing_file'] = 'Fichier %1$s manquant (dans le r�pertoire racine de FreeSeat)';
$lang['config_plugins'] = "S�lection de fonctionalit�s";
$lang['config_seats'] = "Plans de salles";
$lang['config_seats_one'] = "1 plan de salle est disponible.";
$lang['config_seats_n'] = '%$d plans de salle sont disponibles.';
$lang['config_seats_none'] = "Vous n'avez pas encore cr�� de plans de salles.";
$lang['config_spectacles']  = "Spectacles";
$lang['config_spectacles_one'] = "1 spectacle est disponible.";
$lang['config_spectacles_n'] = '%1$d spectacles sont disponibles.';
$lang['config_spectacles_none'] = "Vous n'avez pas encore cr�� de spectacles.";
$lang['config_title'] = "Installation de FreeSeat";

?>

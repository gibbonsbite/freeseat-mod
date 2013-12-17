<?php

require_once (FS_PATH . "plugins/config/languages/default.php");

$lang['config_all_dependencies_found'] = "Toutes les dépendances ont été trouvées.";
$lang['config_bad'] = "indisponible";
$lang['config_button_config'] = "Passer à la configuration";
$lang['config_can_be_found'] = '%1$s peut être téléchargé à %2$s';
$lang['config_click_config'] = 'Cliquez %1$sici%2$s pour effectuer ou modifier votre configuration système.';
$lang['config_click_cron'] = 'Cliquez %1$sici%2$s pour des instructions concernant la configuration du cronjob ou de la tâche périodique.';
$lang['config_click_db'] = 'Cliquez %1$sici%2$s pour configurer la base de données.';
$lang['config_click_gentables'] = 'Générer le script MySQL';
$lang['config_click_seats'] = 'Cliquez %1$sici%2$s pour créer ou modifier des plans de salles.';
$lang['config_click_spectacles'] = 'Cliquez %1$sici%2$s pour créer ou modifier des spectacles.';
$lang['config_config'] = "Configuration système";
$lang['config_congratulations'] = "Félicitations";
$lang['config_cron'] = "Configuration du cronjob";
$lang['config_cron_latest'] = "Le cronjob a été exécuté pour la dernière fois le";
$lang['config_cron_never'] = "Le cronjob n'a encore jamais été exécuté.";
$lang['config_db'] = "Base de données";
$lang['config_db_adminpass'] = 'Choisissez un mot de passe pour l\'utilisateur administrateur';
$lang['config_db_systempass'] = 'Choisissez un mot de passe pour l\'utilisateur système';
$lang['config_db_warning'] = <<<EOD
Attention, après un clic sur ce bouton, vos mots de passe risquent d'être
affichés en clair dans votre browser.
EOD;
$lang['config_dbtables'] = "Base de données";
$lang['config_fplink'] = "Assistant d'installation FreeSeat et configuration système";
$lang['config_good'] = "disponible";
$lang["config_group_configuration"] = 'Configuration';
$lang["config_group_configuration_msg"] = "Plugins utiles pour la configuration de FreeSeat. Assurez-vous qu'ils soient tous sélectionnés lors de l'installation de l'application. Vous pourrez en dé-sélectionner plus tard.";
$lang['config_group_operator'] = 'Operateur';
$lang['config_group_operator_msg'] = "Facilite la vie de l'opérateur";
$lang['config_group_payment'] = 'Paiement';
$lang['config_group_payment_msg'] = "Fournit d'autres moyens de paiement.";
$lang['config_group_tickets'] = 'Billets';
$lang['config_group_tickets_msg'] = "Personnalise l'apparence des billets.";
$lang['config_group_user'] = 'Utilisateur';
$lang['config_group_user_msg'] = "Fonctionnalités utilies pour l'acheteur.";
$lang['config_group_pricing'] = 'Prix';
$lang['config_group_pricing_msg'] = "Permet de modifier le calcul du prix, par exemples par taxes suplémentaires ou offres spéciales.";
$lang['config_index'] = "la page principale de l'assistant";
$lang['config_intro'] = "Bienvenue à FreeSeat! Cet assistant va vous aider à installer et configurer FreeSeat.";
$lang['config_intro_congratulations'] = <<<EOD
Votre installation de FreeSeat est à présent terminée. Vous pouvez
maintenant désactiver les plugins de configuration par le lien
configuration système ci-dessus. Ils pourront être réactivés à tout
moment en visitant cette page.
EOD;
$lang['config_intro_cron'] = <<<EOD
<p>Si vous ne l'avez pas encore fait, assurez-vous que <tt>cron.php</tt> soit exécuté une fois par jour après minuit. Sur la plupart des systèmes linux, il vous faut ajouter la ligne suivante à votre fichier <tt>crontab</tt>, éventuellement après adaptation&nbsp;:</p>
EOD;
$lang['config_intro_plugins'] = <<<EOD
<p>Veuillez sélectionner les fonctionalités ("plugins") 
souhaitées pour votre installation FreeSeat.</p>

<p>Vous pourrez revenir ici à tout moment pour modifier votre sélection si nécessaire.</p>
EOD;
$lang['config_intro_genconfig'] = <<<EOD
  <p>Pour des raisons de sécurité, FreeSeat n'est pas autorisé à
  modifier son propre fichier de configuration.</p>
<p>Veuillez enregistrer le fichier suivant sous le
nom <code>config.php</code> dans le répertoire racine de votre
installation FreeSeat : %1\$sconfig.php%2\$s.</p>
EOD;
$lang['config_intro_gentables'] = <<<EOD
<p>Pour des raisons de sécurité, FreeSeat n'est pas autorisé à modifier
ou créer son propre schéma de base de données.</p>
<p>Veuillez exécuter le script MySQL suivant (essayez un clic droit dans la
boîte puis "Tout sélectionner") à une invite MySQL en tant que root,
ou un utilisateur autorisé à créer et modifier des utilisateurs, des
bases de données et des tables.</p>
EOD;
$lang['config_logged'] = 'et vous êtes connecté';
$lang['config_logged_but_no_db'] = 'Vous êtes connecté mais la base de donnée doit encore être configurée.';
$lang['config_need_syspass'] = "Veuillez également introduire votre mot de passe <em>système</em> pour la vérification de votre configuration&nbsp;:";
$lang['config_missing_dependencies'] = "Certaines dépendances n'ont pas pu être trouvées";
$lang['config_missing_file'] = 'Fichier %1$s manquant (dans le répertoire racine de FreeSeat)';
$lang['config_plugins'] = "Sélection de fonctionalités";
$lang['config_seats'] = "Plans de salles";
$lang['config_seats_one'] = "1 plan de salle est disponible.";
$lang['config_seats_n'] = '%$d plans de salle sont disponibles.';
$lang['config_seats_none'] = "Vous n'avez pas encore créé de plans de salles.";
$lang['config_spectacles']  = "Spectacles";
$lang['config_spectacles_one'] = "1 spectacle est disponible.";
$lang['config_spectacles_n'] = '%1$d spectacles sont disponibles.';
$lang['config_spectacles_none'] = "Vous n'avez pas encore créé de spectacles.";
$lang['config_title'] = "Installation de FreeSeat";

?>

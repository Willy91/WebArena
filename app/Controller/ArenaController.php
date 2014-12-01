<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Validation', 'Utility');

define("LARGEUR_X", 15);
define("LONGUEUR_Y", 10);
define("POINT", 3);
define("DELAI", 10);

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ArenaController extends AppController {

    public $uses = array('Player', 'Fighter', 'Message', 'Event', 'Guild', 'Surrounding', 'Tool');
    public $components = array('Cookie', 'Session');

    /**
     * index method : first page
     *
     * @return void
     */
    public function index() {
        //PAGE D ACCUEIL 
        /*
          un slider des avapaars
         * Retourne un tableau décroissant des fighters classés par level
         * $this->Fighter->getRankFighter()
         */
        $tab = $this->Fighter->getAllFighterview();
        $this->Cookie->check('idFighter');


        $this->set('table_fighter2', $tab);

        if ($this->request->is('post')) {
            $this->redirect(array('controller' => 'arena', 'action' => 'login'));
        }
    }

    public function halloffame() {
        /*

          Ajoutez une page «hall of fame» en espace public où vous présentez une liste de
          statistiques sur les caractéristiques, les dates de connexion etc, en utilisant au moins 4
          «charts» de jqplot
         */
    }

    public function guild() {

        $this->Cookie->check('idFighter');

        if ($this->Cookie->read('nbFighter') > 0) {
            $data = $this->Guild->getAllGuild();
            $tab = array();
            $i = 0;
            foreach ($data as $key) {
                $tab[$i]['Guild'] = $key['Guild'];
                $tab[$i]['Nb'] = $this->Fighter->getNbGuild($key['Guild']['id']);
                $i++;
            }
            $this->set('result_guild', $tab);
            $this->set('name_guild', $this->Guild->getGuildName($this->Fighter->getIdGuild($this->Cookie->read('idFighter'))));
            if ($this->request->is('post')) {
                if (key($this->request->data) == 'CreateGuild') {
                    $this->Guild->createGuild($this->request->data['CreateGuild']['name']);
                    $this->Fighter->joinGuild($this->Cookie->read('idFighter'), $this->Guild->getIdGuild($this->request->data['CreateGuild']['name']));
                    $this->redirect(array('controller' => 'Arena', 'action' => 'guild'));
                    $this->Session->setFlash('You have created the guild. Be brave !', 'flash_success');
                }
                if (key($this->request->data) == 'JoinGuild') {
                    $this->Fighter->joinGuild($this->Cookie->read('idFighter'), $this->Guild->getIdGuild($this->request->data['JoinGuild']['name']));
                    $this->Session->setFlash('You have joined the guild. Honor and Sacrifice !', 'flash_success');
                    $this->redirect(array('controller' => 'Arena', 'action' => 'guild'));
                }
            }
        } else
            $this->redirect(array('action' => 'fighter'));
    }

    function newAction() {

        //A TESTER QUAND CA MARCHERA BIEN
        $nb = $this->Cookie->read("nbAction");
        $pp = $this->Fighter->Action($nb, $this->Cookie->read('idFighter'));
        if ($pp >= 0) {
            $this->Cookie->write('nbAction', $pp);
            return true;
        } else {
            return false;
        }
    }

    public function fighter() {

        $this->Cookie->check('idFighter');

        //pr($this->Cookie);

        if ($this->Cookie->read('nbFighter') == 0)
            $this->Session->setFlash('Welcome to the WebArena. To start the game, please create a fighter', 'flash_success');


        //Fighter view. Need IdFighter
        $tab = $this->Fighter->getAllFighterviewPlayer($this->Session->read('Connected'));

        $this->set('table_fighter2', $tab);


        $this->set('fighter', $this->Cookie->read('idFighter'));
        $this->set('players', $this->Player->find('list'));


        if ($this->request->is('post')) {

            if (key($this->request->data) == 'CreateFighter') {
                if ($this->request->data['CreateFighter']['name'] != "") {

                    if ($this->Fighter->add($this->Session->read('Connected'), $this->request->data['CreateFighter']['name'])) {
                        $new = $this->Fighter->find('first', array('conditions' => array('Fighter.name' => $this->request->data['CreateFighter']['name'])));
                        $this->Event->newFighterEvent($new);
                        $this->Session->setFlash('Your fighter has been created', 'flash_success');
                        if ($this->Cookie->read('nbFighter') == 0) {
                            $tab = $this->Fighter->getFighterByName($this->request->data['CreateFighter']['name']);
                            $this->Cookie->write('idFighter', $tab['Fighter']['id']);
                            $this->Cookie->write('nbFighter', 1);
                        }
                        
                        
                  
                    } else
                        $this->Session->setFlash('Error occured. Name may be already used.', 'flash_error');

                    $this->redirect(array('action' => 'fighter'));
                }
            }
            if ($this->Cookie->read('nbFighter') > 0) {
                if (key($this->request->data) == 'PassLvl') {

                    if ($this->Fighter->upgrade($this->Cookie->read('idFighter'), $this->request->data['PassLvl']['Skill']))
                        $this->Session->setFlash('Congratulations! You leveled up!', 'flash_success');
                    else
                        $this->Session->setFlash('Go back to the war before leveling up.. Dude!', 'flash_error');
                }
                elseif (key($this->request->data) == 'Upload') {
                    if ($this->Fighter->updateAvatar($this->Cookie->read('idFighter'), $this->request->data['Upload']['avatar']['tmp_name']))
                        $this->Session->setFlash('Picture Uploaded !', 'flash_success');
                    else
                        $this->Session->setFlash('You are not cute enough on this picture.. Sorry I cannot upload it !', 'flash_error');
                }
                elseif (key($this->request->data) == 'ReviveFighter') {
                    if ($this->Fighter->reviveFighter($this->Cookie->read('idFighter')))
                        $this->Session->setFlash('Welcome back from the hell! Go back to the battlefield! Be Brave..', 'flash_success');
                    else
                        $this->Session->setFlash('You are not dead.. But I hope you will pass away soon to have try this action!', 'flash_error');
                }

                elseif (key($this->request->data) == 'ChangeFighter') {

                    $id = $this->Fighter->getFighterId($this->request->data['ChangeFighter']['OtherName'], $this->Session->read('Connected'));
                    if (id) {
                        $this->Session->setFlash('Your wish is my command!', 'flash_success');
                        $this->Cookie->write('idFighter', $id);
                    } else
                        $this->Session->setFlash('I don\'t know this fighter..', 'flash_error');
                }
                $this->redirect(array('action' => 'fighter'));
            } else
                $this->redirect(array('action' => 'fighter'));
        }
    }

    public function diary() {
        $this->Cookie->check('idFighter');

        if ($this->Cookie->read('nbFighter') > 0) {
            $tab = $this->Fighter->findById($this->Cookie->read('idFighter'));
            $data = $this->Event->getEvent($tab);
            $this->set('raw', $data);
        } else
            $this->redirect(array('action' => 'fighter'));
    }

    public function resend_password() {
        $this->Cookie->check('idFighter');
        if ($this->request->is('post')) {

            /*          $Email = new CakeEmail('gmail');
              $Email->emailFormat('html');
              $Email->template('forgotten_password','email');
              $Email->to($this->request->data['Password_forgotten']['Email']);
              $Email->subject('Automagically generated email');
              $Email->from ('abruneau@ece.fr');
              $Email->send();
              return $this->redirect(array('action' => 'index'));
             */
            $this->Player->send_email($this->request->data['Password_forgotten']['Email']);
            $this->Session->setFlash('Password Resend !');
            return $this->redirect(array('action' => 'resend_password'));
        }
    }

    public function login() {
        $this->Cookie->check('idFighter');
        if ($this->request->is('post')) {

            if (key($this->request->data) == 'Login') {
                
                

                if ($this->Player->checkLogin($this->request->data['Login']['Email address'], $this->request->data['Login']['Password'])) {

                    $this->Cookie->write('nbAction', 0);
                    $this->Cookie->write('nbFighter', $this->Fighter->find('count', array('conditions' => array('player_id' => $this->Player->getidPlayer($this->request->data['Login']['Email address'])))));


                    $d = $this->Fighter->find('first', array('conditions' => array('player_id' => $this->Player->getidPlayer($this->request->data['Login']['Email address']))));
                    if (!empty($d))
                        $this->Cookie->write('idFighter', $d['Fighter']['id'], false, '1 Month');
                    else
                        $this->Cookie->write('idFighter', -1, false, '1 Month');

                    $this->Session->write('Connected', $this->Player->getidPlayer($this->request->data['Login']['Email address']));
                    $this->Session->setFlash('Welcome back!', 'flash_error');
                    $this->redirect(array('controller' => 'Arena', 'action' => 'fighter'));
                }
                else{
                    $this->Session->setFlash('Error login! Be focus, and type again your ids', 'flash_error');
                }
            }
            elseif (key($this->request->data) == 'Password_forgotten') {
                $this->Player->send_email($this->request->data['Password_forgotten']['Email']);
                $this->Session->setFlash('Email Sent !');

                return $this->redirect(array('action' => 'resend_password'));
            } elseif (key($this->request->data) == 'Signup') {
                if (Validation::email($this->request->data['Signup']['Email address'])){
                if ($this->request->data['Signup']['Password'] == $this->request->data['Signup']['Confirm Password']) {
                    $this->Session->setFlash('Signup !');

                    $this->Player->createNew($this->request->data['Signup']['Email address'], $this->request->data['Signup']['Password']);
                }
                }
                else
                     $this->Session->setFlash('Error in your email', 'flash_error');
                
            }
        }
    }

    public function message() {

        $this->Cookie->check('idFighter');

        $this->set('message_table', $this->Message->getAllMessage($this->Cookie->read('idFighter')));

        if ($this->Cookie->read('nbFighter') > 0) {


            if ($this->request->is('post')) {
                if (key($this->request->data) == 'SendEmail') {
                    $this->redirect(array('action' => 'message_display'));
                }
                if (key($this->request->data) == 'EmailSent') {
                    $this->redirect(array('action' => 'message_sent'));
                }
                if (key($this->request->data) == 'EmailBox') {
                    $this->redirect(array('action' => 'message'));
                }
            }
        } else
            $this->redirect(array('action' => 'fighter'));
    }

    public function message_sent() {

        $this->Cookie->check('idFighter');

        $this->set('message_table', $this->Message->getAllMessageSent($this->Cookie->read('idFighter')));




        if ($this->request->is('post')) {
            if (key($this->request->data) == 'SendEmail') {
                $this->redirect(array('action' => 'message_display'));
            }
            if (key($this->request->data) == 'EmailSent') {
                $this->redirect(array('action' => 'message_sent'));
            }
            if (key($this->request->data) == 'EmailBox') {
                $this->redirect(array('action' => 'message'));
            }
        }
    }

    public function message_display() {
        $this->Cookie->check('idFighter');
        $data = $this->Fighter->getFighterForMessage($this->Cookie->read('idFighter'));
        $tab = array();
        $n = 0;
        foreach ($data as $option) {
            $tab[$option['Fighter']['name']] = $option['Fighter']['name'];
        }

        $this->set('fighter_option', $tab);
        $this->set('fighter_defaut', $data[0]['Fighter']['name']);

        if ($this->request->is('post')) {
            if (key($this->request->data) == 'Back') {
                $this->redirect(array('action' => 'message'));
            }
            if (key($this->request->data) == 'CreateMessage') {
                $data = array();
                $data['title'] = $this->request->data['CreateMessage']['object'];
                $data['message'] = $this->request->data['CreateMessage']['message'];
                $dest = $this->Fighter->getFighterByName($this->request->data['CreateMessage']['to']);

                if ($this->Message->sendMessage($data, $this->Cookie->read('idFighter'), $dest))
                    $this->Session->setFlash('The message has been sent', 'flash_success');
                else
                    $this->Session->setFlash('The message has not been sent', 'flash_error');


                $this->redirect(array('action' => 'message'));
            }
        }
    }

    public function logout() {

        $this->Session->delete('Connected');
        $this->Session->setFlash('Logout !');
        $this->redirect(array('controller' => 'Arena', 'action' => 'index'));
    }

    public function BeforeFilter() {


        if (!$this->Session->read('Connected') && $this->request->params['action'] != 'login' && $this->request->params['action'] != 'index' && $this->request->params['action'] != 'signup') {
            if ($this->request->params['action'] != 'login' && $this->request->params['action'] != 'signup' && $this->request->params['action'] != 'index' && $this->request->params['action'] != 'halloffame') {
                $this->request->params['action'];
                $this->redirect(array('controller' => 'Arena', 'action' => 'login'));
            }
        }
    }

    public function sight() {
        /*         * Elle affichera les combattants et les objets du décors en vue classés par
          distance croissante.
         * 
         * faites apparaître un tooltip au survol des trucs sur le damier.
         * 
         * * */
        $this->Cookie->check('idFighter');
        //Réinitialiser les objets s'ils ont tous été rammasé  
        if ($this->Cookie->read('nbFighter') > 0) {

            $this->Tool->useAgainTool($this->Surrounding->getAllSurrounding());

            //A ENLEVER SAUF POUR CEUX QUI N ONT PAS ENCORE INITIALISE LA BDD DES OBJETS ET DES SURROUNDING
            // $this->Surrounding->beginGame();
            // $this->Tool->initPosition();
            //Partie à alex
            $dd1 = $this->Surrounding->getSurroundingSight($this->Fighter->findById($this->Cookie->read('idFighter')));
            $dd2 = $this->Tool->getToolSight($this->Fighter->findById($this->Cookie->read('idFighter')));

            $this->set('result_sight', $dd1);
            $this->set('result_tool', $dd2);
            $this->set('idF', $this->Cookie->read('idFighter'));
            //$this->set('result_fighter',$this->Fighter->getSeen(1));
            //$this->set('result_fighter',$this->Fighter->find('all'));
            $this->set('result_fighter', $this->Fighter->getSeen($this->Cookie->read('idFighter')));

            //Alex
            $this->set('me', $this->Fighter->findById($this->Cookie->read('idFighter')));
            $c = $this->Surrounding->nearFromPiege($this->Fighter->findById($this->Cookie->read('idFighter')));
            $d = $this->Surrounding->nearFromMonster($this->Fighter->findById($this->Cookie->read('idFighter')));
            $this->set('neartrap', $c);
            $this->set('nearmonster', $d);
            //Si on a des paramètres reçus en post
            if ($this->request->is('post')) {
                //Si le mec veut bouger 
                if (key($this->request->data) == 'Tool') {
                    //   $this->newAction();
                    $a = $this->newAction();
                    if ($a) {//Do Move 
                        $bool = $this->Tool->fighterOnTool($this->Fighter->getFighterview($this->Cookie->read('idFighter')));
                        if ($bool[0]) {
                            $fighter = $this->Cookie->read('idFighter');
                            $this->Event->getToolEvent($fighter, $bool[1]);
                            $this->Session->setFlash('You picked the tool !', 'flash_success');
                        } else {
                            $this->Session->setFlash('Go away! There is nothing here!', 'flash_error');
                        }
                    } else
                        $this->Session->setFlash('You get the limit of actions in a short time. Be patient!', 'flash_error');
                }

                elseif (key($this->request->data) == 'Fightermove') {
                    $a = $this->newAction();
                    if ($a) {//Do Move 
                        $result_move = $this->Fighter->doMove($this->Cookie->read('idFighter'), $this->request->data['Fightermove']['direction']);
                        if ($result_move == 1) {

                            $this->Session->setFlash('Yeah you moved!', 'flash_success');

                            $this->Event->MoveEvent($this->Fighter->findById($this->Cookie->read('idFighter')), $this->request->data['Fightermove']['direction']);
                        } else {

                            if ($result_move == 2) {
                                $this->Session->setFlash('So What? You are dead! You cannot move !!!', 'flash_error');
                            } else
                                $this->Session->setFlash('You cannot move !! Something blocks the way..', 'flash_error');
                            $this->Event->FailMove($this->Fighter->findById($this->Cookie->read('idFighter')), $this->request->data['Fightermove']['direction']);
                        }
                    } else
                        $this->Session->setFlash('You get the limit of actions in a short time. Be patient!', 'flash_error');


                    $tab = $this->Surrounding->getSurroundingSight($this->Fighter->findById($this->Cookie->read('idFighter')));
                    $tab2 = $this->Tool->getToolSight($this->Fighter->findById($this->Cookie->read('idFighter')));
                    $this->set('result_sight', $this->Surrounding->getSurroundingSight($this->Fighter->findById($this->Cookie->read('idFighter'))));
                    $this->set('result_tool', $this->Tool->getToolSight($this->Fighter->findById($this->Cookie->read('idFighter'))));


                    //Retourn True si le fighter est mort à cause d'un piège
                    if ($this->Fighter->deathFromSurrounding($this->Cookie->read('idFighter'), $this->Surrounding->fighterOnPiege($this->Fighter->findById($this->Cookie->read('idFighter'))))) {
                        $this->Session->setFlash('You have been trapped.. YOU ARE DEAD! BYE BYE!', 'flash_error');

                        $this->Event->TrapEvent($this->Fighter->findById($this->Cookie->read('idFighter')));
                        $this->Event->NewDeathEvent($this->Fighter->findById($this->Cookie->read('idFighter')));
                    }
                    //Return True si le fighter est mort à cause du monstre
                    if ($this->Fighter->deathFromSurrounding($this->Cookie->read('idFighter'), $this->Surrounding->fighterOnMonster($this->Fighter->findById($this->Cookie->read('idFighter'))))) {
                        $this->Session->setFlash('Do you smell the odor of the death? YOU ARE DEAD', 'flash_error');
                        $this->Event->DeathMonsterEvent($this->Fighter->findById($this->Cookie->read('idFighter')));
                        $this->Event->NewDeathEvent($this->Fighter->findById($this->Cookie->read('idFighter')));
                    }
                    /*
                      $this->Fighter->deathFromSurrounding(1, $a); */

                    // $this->Session->setFlash('Une action a été réalisée.', 'flash_success');

                    $this->redirect(array('controller' => 'Arena', 'action' => 'sight'));
                } elseif (key($this->request->data) == 'FighterAttack') {

                    $a = $this->newAction();
                    if ($a) {//Do Move   
                        $test = $this->Fighter->doAttack($this->Cookie->read('idFighter'), $this->request->data['FighterAttack']['direction']);
                        if ($test[0] == 1) {
                            $this->Event->MonsterEvent($this->Fighter->findById($this->Cookie->read('idFighter')));
                            $this->Session->setFlash('What a man!! You killed the monster!', 'flash_success');
                        } elseif ($test[0] == 2) {
                            $this->Event->NobodyAttackEvent($this->Fighter->findById($this->Cookie->read('idFighter')));
                            $this->Session->setFlash('Why did you attack in this direction? There is nobody! What a fail move!', 'flash_error');
                        } elseif ($test[0] == 3) {

                            if ($test[2]) {
                                $this->Session->setFlash('You killed him! May he rest in peace!', 'flash_success');
                            } else {
                                if ($test[1]) {
                                    $this->Session->setFlash('He is not dead! Come on guy !!', 'flash_success');
                                    $this->Event->DoAttackEvent($test[1], $this->Cookie->read('idFighter'));
                                } else {
                                    $this->Session->setFlash('You failed your attack! Paid attention on the revenge!', 'flash_error');
                                    $this->Event->failAttackEvent($this->Cookie->read('idFighter'), $test[1]);
                                }
                            }
                        }
                    } else
                        $this->Session->setFlash('You get the limit of actions in a short time. Be patient!', 'flash_error');
                }

                elseif (key($this->request->data) == 'Scream') {
                    $a = $this->newAction();
                    if ($a) {//Do Move 
                        $this->Event->Crier($this->Fighter->findById($this->Cookie->read('idFighter')), $this->request->data["Scream"]['name']);
                        $this->Session->setFlash('You have Screamed !', 'flash_success');
                    } else
                        $this->Session->setFlash('You get the limit of actions in a short time. Be patient!', 'flash_error');
                }
            }
        } else
            $this->redirect(array('action' => 'fighter'));
    }

}

?>

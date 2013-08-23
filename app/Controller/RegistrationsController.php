<?php class RegistrationsController extends AppController{  var $name       = 'Registrations';  var $uses       = array('Npo','NpoTemplateSection');  var $components  = array('Uploader.Uploader');   /**	* @Date: October 17, 2011	* @Method : index	* @Purpose: This function is for registration.	* @Param: none	* @Return: none 	**/  function index(){    $loggedIn = $this->Session->read('SESSION_USER.Npo.id');    if(isset($loggedIn) && !empty($loggedIn)){      $this->Session->setFlash('<div class="fail">Please logout from your account first.</div>');      $this->redirect('/');    }    $memLoggedIn = $this->Session->read('SESSION_USER.Member.id');     if(isset($memLoggedIn) && !empty($memLoggedIn)){      $this->Session->setFlash('<div class="fail">Please logout from your account first.</div>');      $this->redirect('/');    }    $this->layout = 'layout_inner';    App::import('Model','Template');    $this->Template = new Template();    $this->Template->bindModel(                            array(                              'hasMany'=>array(                                'TemplateTheme'=>array(                                  'className' =>'TemplateTheme',                                  'fields'     =>'TemplateTheme.id,TemplateTheme.image,TemplateTheme.name',                                  'conditions'  =>array('TemplateTheme.status'=>'Active')                                )                              )                            ),false                          );    $templates = $this->Template->find('all',array('fields'=>array('Template.id,Template.name'),'conditions'=>array('Template.status'=>'Active')));    //pr($templates);die();    $this->set('templates',$templates);    if(!empty($this->request->data)){      if($this->request->data['Npo']['agree'] == 1){                    if($this->request->data['Npo']['password'] !== $this->request->data['Npo']['confirmPassword']){            $this->Session->setFlash('<div class="fail">Password and confirm password do not match.</div>');          }else if(!$this->chkDuplicateFields($this->request->data['Npo']['email'],'email','Npo')){             $this->Session->setFlash('<div class="fail">Email '.$this->request->data['Npo']['email'].' is unavailable</div>');          }else if(!$this->chkDuplicateFields(strtolower($this->request->data['Npo']['siteAddress']),'address','Npo')){             $this->Session->setFlash('<div class="fail">Address '.$this->request->data['Npo']['siteAddress'].' is unavailable</div>');          }else if(!$this->chkDuplicateFields($this->request->data['Npo']['title'],'title','Npo')){             $this->Session->setFlash('<div class="fail">Title '.$this->request->data['Npo']['title'].' is unavailable</div>');          }else if($this->request->data['Npo']['templateId'] == 0 || $this->request->data['Npo']['themeId'] == 0){            $this->Session->setFlash('<div class="fail">Please select a template and a theme.</div>');          }else if(!$this->chkSubscribed($this->request->data['Npo']['email'])){            $this->Session->setFlash('<div class="fail">Email '.$this->request->data['Npo']['email'].' is not subsribed.</div>');                      }else{              $this->Npo->set($this->request->data);                $this->request->data['Npo']['siteAddress'] = strtolower($this->request->data['Npo']['siteAddress']);                if($this->Npo->validates()){                  $data = array();                  $this->Uploader->uploadDir = Configure::read('CHURCH_IMAGE_PATH');                  if($imgData = $this->Uploader->upload('image')){                      $data['image'] = $imgData['name'];                      $thumb = $this->Uploader->resize(array('width' => thumbWidth ,'height'=> thumbHeight));                      $arrThumb = explode('/',$thumb);                      $data['thumb'] = $arrThumb[3];                  }                  $data['email']       = $this->request->data['Npo']['email'];                  $data['password']    = $this->request->data['Npo']['password'];                  $data['address']     = $this->request->data['Npo']['siteAddress'];                  $data['title']       = $this->request->data['Npo']['title'];                  $data['description'] = $this->request->data['Npo']['description'];                  if($this->request->data['Npo']['verify'] == 'taxid'){                    $data['taxid'] = $this->request->data['Npo']['taxid'];                   }else{                    $data['corporate_name']    = $this->request->data['Npo']['corpName'];                     $data['corporate_address'] = $this->request->data['Npo']['corpAddress'];                                     }                  $this->Npo->save($data);                  $npoId = $this->Npo->getLastInsertID();                  App::import('Model','NpoTemplate');                  $this->NpoTemplate = new NpoTemplate();                  $templateData = array();                  $templateData['template_id']        = $this->request->data['Npo']['templateId'];                  $templateData['template_theme_id']  = $this->request->data['Npo']['themeId'];                  $templateData['npo_id']             = $npoId;                  $this->NpoTemplate->save($templateData);                  $sectionData = array();                  $sectionData['id'] = '';                  $sectionData['npo_id'] = $npoId;                  $sectionData['template_section_id'] = 1;                  $this->save_dummy_data($npoId);                  $this->NpoTemplateSection->save($sectionData);                  if($this->request->data['Npo']['about'] != 0){                    $sectionData['template_section_id'] = $this->request->data['Npo']['about'];                    $this->NpoTemplateSection->save($sectionData);                  }                  if($this->request->data['Npo']['contact'] != 0){                    $sectionData['template_section_id'] = $this->request->data['Npo']['contact'];                    $this->NpoTemplateSection->save($sectionData);                   }                  if($this->request->data['Npo']['store'] != 0){                    $sectionData['template_section_id'] = $this->request->data['Npo']['store'];                    $this->NpoTemplateSection->save($sectionData);                  }                  if($this->request->data['Npo']['services'] != 0){                    $sectionData['template_section_id'] = $this->request->data['Npo']['services'];                    $this->NpoTemplateSection->save($sectionData);                  }                  if($this->request->data['Npo']['calender'] != 0){                    $sectionData['template_section_id'] = $this->request->data['Npo']['calender'];                    $this->NpoTemplateSection->save($sectionData);                  }                  if($this->request->data['Npo']['testimonial'] != 0){                    $sectionData['template_section_id'] = $this->request->data['Npo']['testimonial'];                    $this->NpoTemplateSection->save($sectionData);                   }                  if($this->request->data['Npo']['blog'] != 0){                    $sectionData['template_section_id'] = $this->request->data['Npo']['blog'];                    $this->NpoTemplateSection->save($sectionData);                  }                  if($this->request->data['Npo']['gallery'] != 0){                    $sectionData['template_section_id'] = $this->request->data['Npo']['gallery'];                    $this->NpoTemplateSection->save($sectionData);                  }                                 $returnVal =  $this->create_directories($sectionData['npo_id'],$this->request->data['Npo']['siteAddress']);                  if(is_array($returnVal) && !empty($returnVal)){                    $str = '';                    foreach($returnVal as $key=>$val){                      $str .= $val.'<br />';                    }                    $str = rtrim($str,'<br />');                    $this->Session->setFlash('<div class="fail">'.$str.'</div>');                  }/* Un comment to make a manual new site(files will be written)else{                    $retVal = $this->create_site($sectionData['npo_id'],$this->request->data['Npo']['siteAddress'],$this->request->data['Npo']['themeId'],$menu);                      if(is_array($retVal) && !empty($retVal)){                        $str = '';                        foreach($retVal as $key=>$val){                          $str .= $val.'<br />';                        }                        $str = rtrim($str,'<br />');                        $this->Session->setFlash('<div class="fail">'.$str.'</div>');                       }else{                       }                  }*/                  $this->Session->setFlash('<div class="success">Registration completed successfully.<br />Your site address is <a style="color:#fff;text-decoration:underline" target="_blank" href="/site/'.$this->request->data['Npo']['siteAddress'].'/">http://'.$_SERVER['HTTP_HOST'].'/site/'.$this->request->data['Npo']['siteAddress'].'/'.'</a></div>');                  $this->redirect('/');                }                  }      }else{        $this->Session->setFlash('<div class="fail">Please accept terms of services.</div>');            }    }  }//ef     /**	* @Date: December 22, 2011	* @Method : save_dummy_data	* @Purpose: This function is to save npo site related dummy data.	* @Param: npo_id,address	* @Return: none 	**/  function save_dummy_data($npoId){    App::import('Model','NpoContent');    $this->NpoContent = new NpoContent();    $data = array();      $data['npo_id']     = $npoId;    $data['window_title'] = 'Lorem Ipsum';    $data['page_title'] = 'Lorem <span>Ipsum</span>';    $data['first_title'] = 'Lorem Ipsum comes from sections';    $data['first_desc'] = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>";    $data['second_title'] = 'Lorem Ipsum comes from sections';    $data['second_desc'] = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>        <p>dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>";    $data['third_title'] = 'Lorem Ipsum comes from sections';    $data['third_desc'] = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>        <p>dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>";    $data['fourth_title'] = 'Lorem Ipsum comes from sections';    $data['fourth_desc'] = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>        <p>dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>";    $data['fifth_title'] = 'Lorem Ipsum comes from sections';    $data['fifth_desc'] = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>        <p>dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>";    $this->NpoContent->save($data);  }//ef   /**	* @Date: December 15, 2011	* @Method : create_directories	* @Purpose: This function is to create npo related direcrories.	* @Param: npo_id,address	* @Return: none 	**/	function create_directories($npo_id,$address){     $error = 0 ;     $msg = array();     if(mkdir(Configure::read('siteDirectory').$address)){        if(!chmod(Configure::read('siteDirectory').$address,0777)){          $error = 1 ;          $msg[] = 'Error setting permissions in Church/Npo directory.';        }           }else{        $error = 1 ;        $msg[] = 'Error creating Church/Npo directory.';     }     if(mkdir(Configure::read('npoDirectory').$npo_id)){        if(!chmod(Configure::read('npoDirectory').$npo_id,0777)){          $error = 1 ;          $msg[] = 'Error setting permissions in Church/Npo storage directory.';        }          }else{        $error = 1 ;        $msg[] = 'Error creating Church/Npo storage directory.';          }     if(mkdir(str_replace('{id}',$npo_id,Configure::read('npoNewsDirectory')))){        if(!chmod(str_replace('{id}',$npo_id,Configure::read('npoNewsDirectory')),0777)){          $error = 1 ;          $msg[] = 'Error setting permissions in Church/Npo news directory.';                  }     }else{        $error = 1 ;        $msg[] = 'Error creating Church/Npo news directory.';     }     if(mkdir(str_replace('{id}',$npo_id,Configure::read('npoEventDirectory')))){        if(!chmod(str_replace('{id}',$npo_id,Configure::read('npoEventDirectory')),0777)){          $error = 1 ;          $msg[] = 'Error setting permissions in Church/Npo events directory.';                  }     }else{        $error = 1 ;        $msg[] = 'Error creating Church/Npo events directory.';          }     if(mkdir(str_replace('{id}',$npo_id,Configure::read('npoImageDirectory')))){        if(!chmod(str_replace('{id}',$npo_id,Configure::read('npoImageDirectory')),0777)){          $error = 1 ;          $msg[] = 'Error setting permissions in Church/Npo image directory.';                  }     }else{        $error = 1 ;        $msg[] = 'Error creating Church/Npo image directory.';          }    if($error === 0){      return true;    }else{      return $msg;    }  }  //ef       /**	* @Date: December 15, 2011	* @Method : create_site	* @Purpose: This function is to create site of the npo.	* @Param: npo_id,address,templateid,themeid	* @Return: none 	**/	/*function create_site($npoId,$address,$themeId,$menu){	   $msg = array();	   $error = 0;	   App::import('Model','TemplateTheme');	   $this->TemplateTheme = new TemplateTheme();	   	   		$this->TemplateTheme->bindmodel(		              array(		                'belongsTo'=>array(                      'Template' =>array(                          'className'=>'Template'                      )                    )                  ),false          );    $templateDetails = $this->TemplateTheme->find('first',array('fields'=>array('Template.name,TemplateTheme.name'),'conditions'=>array('TemplateTheme.id'=>$themeId)));	  $template = $templateDetails['Template']['name'];	  $theme    = $templateDetails['TemplateTheme']['name'];    $templateHtml = file_get_contents(Configure::read('SITE_TEMPLATE_ROOT').$template.'/'.$theme.'/index.php'); 	        if($templateHtml){            if(!mkdir(Configure::read('siteDirectory').$address.'/images')){              $error = 1;              $msg[] = 'Error creating template image directory.';                          }else{              if(!chmod(Configure::read('siteDirectory').$address.'/images',0777)){                $error = 1;                $msg[] = 'Error setting permission on images directory.';                             }            }            if($imgHandle = opendir(Configure::read('SITE_TEMPLATE_ROOT').$template.'/'.$theme.'/images/')){            while (false !== ($img = readdir($imgHandle))) {                if($img !='.' && $img !='..'){                  if(!copy(Configure::read('SITE_TEMPLATE_ROOT').$template.'/'.$theme.'/images/'.$img,Configure::read('siteDirectory').$address.'/images/'.$img)){                    $error = 1;                  }                }            }            if($error == 1){                            $msg[] = 'Error copying images to template image directory.';               }       }else{          $error = 1;          $msg[] = 'Error opening template image directory.';               }	     $templateHtml = str_replace('{MAIN_MENU}',$menu,$templateHtml);	     $writeHtml = fopen(Configure::read('siteDirectory').$address.'/index.php','w+');	     if(!fwrite($writeHtml,$templateHtml)){          $error = 1;          $msg[] = 'Error writing site files.';                 }            	            fclose($writeHtml);       $templateCss  =  file_get_contents(Configure::read('SITE_TEMPLATE_ROOT').$template.'/'.$theme.'/css/style.css');       if($templateCss){            if(mkdir(Configure::read('siteDirectory').$address.'/css')){              if(chmod(Configure::read('siteDirectory').$address.'/css',0777)){               $writeCss = fopen(Configure::read('siteDirectory').$address.'/css/style.css','w+');               if(!fwrite($writeCss,$templateCss)){                  $error = 1;                  $msg[] = 'Error writing site style files.';               }               }else{                  $error = 1;                  $msg[] = 'Error setting permissions in site style directory.';                            }           }else{          $error = 1;          $msg[] = 'Error creating site style directory.';           }       }else{          $error = 1;          $msg[] = 'Error reading site style files.';       }    }else{      $error = 1;      $msg[] = 'Error reading template files.';    }    if($error === 0){      return true;    }else{      return $msg;    }  }//ef  */   /**	* @Date: December 06, 2011	* @Method : registration_member	* @Purpose: This function is for registration.	* @Param: none	* @Return: none 	**/	function registration_member(){	     $loggedIn = $this->Session->read('SESSION_USER.Npo.id');    if(isset($loggedIn) && !empty($loggedIn)){      $this->Session->setFlash('<div class="fail">Please logout from your account first.</div>');      $this->redirect('/');    }     $memLoggedIn = $this->Session->read('SESSION_USER.Member.id');     if(isset($memLoggedIn) && !empty($memLoggedIn)){      $this->Session->setFlash('<div class="fail">Please logout from your account first.</div>');      $this->redirect('/');    }    $this->layout = 'layout_inner';    App::import('Model','Member');    $this->Member = new Member();    if(!empty($this->request->data)){    $session = 	$this->Session->read('iQaptcha');    if(isset($_POST['iQapTcha']) && empty($_POST['iQapTcha']) && isset($session) && $session){         if($this->request->data['Member']['agree'] == 1){            if($this->request->data['Member']['usrPassword'] === $this->request->data['Member']['confPassword']){              $this->Member->set($this->request->data);              if($this->Member->validates()){                $data                = array();                $data['password']    = $this->request->data['Member']['usrPassword'];                $data['name']        = $this->request->data['Member']['usrName'];                $data['email']       = $this->request->data['Member']['email'];                $data['description'] = $this->request->data['Member']['description'];                $this->Member->save($data);                $this->Session->delete('iQaptcha');                $this->Session->setFlash('<div class="success">Thanx for registration.You can now login and join any Church/NPO</div>');                $this->redirect('/');              }          }else{              $this->Session->setFlash('<div class="fail">Password and confirm password do not match.</div>');            }        }else{              $this->Session->setFlash('<div class="fail">Please accept Terms Of Service.</div>');              }      }else{        $this->Session->setFlash('<div class="fail">Please slide the slider to unlock the form before submitting.</div>');       }    }      }//ef}//ec?>
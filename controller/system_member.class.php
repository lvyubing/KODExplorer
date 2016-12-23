<?php class system_member extends Controller{public static $static_sql=null;private $sql;function __construct(){parent::__construct();��������������ư�������ծɷ��������٘���;$this->tpl=TEMPLATE.'member/';$this->sql=self::load_data();}public static function load_data(){if(is_null(self::$static_sql)){self::$static_sql=system_member_data();}return self::$static_sql;}public static function get_info($�){$Δ��=self::load_data();return $Δ��->get($�);}public static function space_change($�,$呺��=false){$��瀷=self::load_data();�֗ކ��薶�����Đ����Ǵ�����ӹפ�������׬���;$��吓=$��瀷->get($�);��������;if(!is_array($��吓)){show_json($this->L["data_not_full"],!1);}if($呺��===!1){$��=_path_info_more(USER_PATH.$��吓['path'].'/');$�=$��['size'];if(isset($��吓['home_path'])&& file_exists(iconv_app($��吓['home_path']))){$��=_path_info_more(iconv_app($��吓['home_path']));$�+= $��['size'];}}else{$�=floatval($��吓['config']['size_use'])+floatval($呺��);}$��吓['config']['size_use']=$�<0?0:$�;$��瀷->set($�,$��吓);}public static function space_check($�){$��=self::load_data();�Ɍ��ۓ����ق�������Α�Ф���嵓�;$�=$��->get($�);���ȡ�����Ȩ��������甛�����;if(!is_array($�)){show_json($this->L["data_not_full"],!1);}$����=floatval($�['config']['size_use']);$�����=floatval($�['config']['size_max']);if($�����!=0&& $�����*0x0000040000000<$����){show_json($GLOBALS['L']['space_is_full'],!1);}}public static function group_remove_user_update($ނ�){$����=self::load_data();$��=$����->get();foreach($�� as $�=>$�){if(in_array($ނ�,array_keys($�['group_info']))){unset($�['group_info'][$ނ�]);$����->set($�['user_id'],$�);}}}public static function role_remove_user_update($�){$��=self::load_data();�ѝ���ۯ➞�ȡ�������;$ၭ=$��->get();foreach($ၭ as $��=>$֡���){if($֡���['role']==$�){$֡���['role']='';$��->set($֡���['user_id'],$֡���);}}}public static function user_auth_group($���){$�=self::load_data();$і�=$�->get($_SESSION['kod_user']['user_id']);��;$�=$і�['group_info'];�����骨�����䣪��;if(!is_array($�)){return !1;}if(isset($�[$���])){return $�[$���];}foreach($� as $���=>$����){$�ֺ�=system_group::get_info($���);$��=explode(',',$�ֺ�['children']);if(in_array($���,$��)){return $�[$���];}}return !1;�ҥ����ʄ���ㄾۅ�ю����ኙ��ޥ�����;}public static function _filter_list($ߞڛ,$���='path'){if($GLOBALS['is_root'])return $ߞڛ;foreach($ߞڛ as $�ě�=>&$����){unset($����[$���]);unset($����['password']);}return $ߞڛ;��˕헏����ɋ�؋٨�Õ���Ȣ�;}public static function get_user_at_group($��){$��έ=self::load_data();�����;$���=self::_filter_list($��έ->get());������;if($��=='0'){return $���;}$�С͜=array();foreach($��� as $�){if(isset($�['group_info'][$��])){$�С͜[]=$�;}}return $�С͜;��߮�ϔ��ӷ;}public static function user_share_sql($���){static $����;if(!is_array($����)){$����=array();}if(!isset($����[$���])){$����=system_member::get_info($���);if(!isset($����['path'])){return;}$��=new fileCache(USER_PATH.$����['path'].'/data/share.php');$����[$���]=$��;}return $����[$���];�ɼ�����Ҋړ��ɍ����݌ԙ�ۦ�ӓ͞�Ǩ�긠�˒�������Ǥ�����������Ȑ����;}public static function user_share_list($�Ų��){$���=self::user_share_sql($�Ų��);�岧�Ġ;$�=$���->get();��;if($�Ų��==$_SESSION['kod_user']['user_id']){return $�;}foreach($� as $���=>&$���){unset($���['share_password']);}return $�;}public static function user_share_get($�ߨ,$ڦ��){$���ӧ=self::user_share_sql($�ߨ);��ⴺ��Ӫ���ܚ�����ԛ��������ɂ���;return $���ӧ->get('name',$ڦ��);���ۢ�͝���㺭�������µ�Ū�ĳԠ�����盜��;}public function get($���='0'){$�=self::get_user_at_group($���);���̘������Ƃ�;show_json($�);���߫˪П�衅���܆޾�������⥷���������;}public function add(){if(!isset($this->in['name'])|| !isset($this->in['password'])|| !isset($this->in['role'])|| !isset($this->in['group_info'])|| !isset($this->in['size_max']))show_json($this->L["data_not_full"],!1);$��=trim(rawurldecode($this->in['name']));$�����=rawurldecode($this->in['password']);�����˽�����뮫�����������Ǐ�;$��=json_decode(rawurldecode($this->in['group_info']),!0);��י���Ϸ��щ������֋���ȅϣ���ƃ̗��̍ߴ����ė���������;if(!is_array($��)){show_json($this->L["system_member_group_error"],!1);}if($this->sql->get(array('name',$��))){show_json($this->L['error_repeat'],!1);}if(!$GLOBALS['is_root']&& $this->in['role']=='1'){show_json($this->L['group_role_error'],!1);}$�����=array();if(isset($this->in['isImport'])){$���=explode("\n",$��);foreach($��� as $���){if(trim($���)!=''){$�����[]=trim($���);}}}else{$�����[]=$��;�������ǃɚ��⤆Ѥ��������޴���긆ဉ�����鼴��Ȝ������թ�О���ي�����Ԡۉܼ��١������ڴ��;}$����=array();��ܱ���;foreach($����� as $�˄){if($this->sql->get('name',$�˄)){$����[]=$�˄;continue;}$�=$this->sql->get_max_id().'';$��=array('user_id' =>$�,'name' =>$�˄,'password' =>md5($�����),'role' =>$this->in['role'],'config' =>array('size_max' =>floatval($this->in['size_max']),'size_use' =>0x00000400*0x00000400),'group_info'=> $��,'path' =>hash_path($�˄),'status' =>0x001,'last_login'=> '','create_time'=> time(),);if(!$GLOBALS['is_root']){show_json($this->L['no_permission'],!1);}if(isset($this->in['home_path'])){$��['home_path']=_DIR(rawurldecode($this->in['home_path']));if(!file_exists($��['home_path'])){show_json($this->L['not_exists'],!1);}$��['home_path']=iconv_app($��['home_path']);}else{unset($��['home_path']);}if($this->sql->set($�,$��)){$this->_initDir($��['path']);}else{$����[]=$�˄;}}$���=count($�����)-count($����);$�=" success:$���";if($���==count($�����)){show_json($this->L['success'].$�,!0,$���);}else if($���!=0){$�Ő�=" error:".count($����);show_json($this->L['success'].$�.$�Ő�,!1,implode("\n",$����));}else{show_json($this->L['error_repeat'],!1);}}public function edit(){if(!$this->in['user_id'])show_json($this->L["data_not_full"],!1);$�͋�=$this->in['user_id'];��䂨�����Ȏ������՞��������;$��=$this->sql->get($�͋�);���������;if(!$��){show_json($this->L['error'],!1);}if(!$GLOBALS['is_root']&& $this->in['role']=='1'){show_json($this->L['group_role_error'],!1);}if(!$GLOBALS['is_root']&& $��['role']=='1'){show_json($this->L['group_role_error_admin'],!1);}if($GLOBALS['is_root']&& $_SESSION['kod_user']['user_id']==$�͋�&& $this->in['role']!='1'){show_json($this->L['error'],!1);}$�퀅=trim(rawurldecode($this->in['name']));if($��['name']!=$�퀅){if($this->sql->get(array('name',$�퀅))){show_json($this->L['error_repeat'],!1);}}$this->in['name']=rawurlencode($�퀅);���҄����ؗ��텒푙���;$��=array('name','role','password','group_info','home_path','status','size_max');�ހ���������������΁���������;foreach($�� as $�){if(!isset($this->in[$�]))continue;$��[$�]=rawurldecode($this->in[$�]);��ɩ������������ŉ����О���Б��;if($�=='password'){$��['password']=md5($��[$�]);}else if($�=='size_max'){$��['config']['size_max']=floatval($��[$�]);}else if($�=='group_info'){$��['group_info']=json_decode(rawurldecode($this->in['group_info']),!0);}}if(!$GLOBALS['is_root']){show_json($this->L['no_permission'],!1);}if(isset($this->in['home_path'])){$��['home_path']=_DIR(rawurldecode($this->in['home_path']));if(!file_exists($��['home_path'])){show_json($this->L['not_exists'],!1);}$��['home_path']=iconv_app($��['home_path']);}else{unset($��['home_path']);}if($this->sql->set($�͋�,$��)){self::space_change($�͋�);show_json($this->L['success'],!0,$��);}show_json($this->L['error_repeat'],!1);}public function do_action(){if(!isset($this->in['user_id'])){show_json($this->L["username_can_not_null"],!1);}$����=$this->in['action'];$ű=json_decode($this->in['user_id'],!0);if(!is_array($ű)){show_json($this->L['error'],!1);}if(in_array('1',$ű)){show_json($this->L['default_user_can_not_do'],!1);}foreach($ű as $���){switch($����){case 'del':$��=$this->sql->get($���);if($this->sql->remove($���)&& $��['name']!=''){del_dir(USER_PATH.$��['path'].'/');}break;case 'status_set':$�=intval($this->in['param']);���;$this->sql->set(array('user_id',$���),array('status',$�));���ʬ��Ҁ��޿��򺹯���㸠����͵�;break;case 'role_set':$����=$this->in['param'];�������׮�����ڗ��غ��Ӽ���;if(!$GLOBALS['is_root']&& $����=='1'){show_json($this->L['group_role_error'],!1);}$this->sql->set(array('user_id',$���),array('role',$����));break;case 'group_reset':$��=json_decode($this->in['param'],!0);��髕�̌ѧ���ȂΣ�����ҕ;if(!is_array($��)){show_json($this->L['error'],!1);}$this->sql->set(array('user_id',$���),array('group_info',$��));break;case 'group_remove_from':$�=$this->in['param'];$��=$this->sql->get($���);��ă�;unset($��['group_info'][$�]);��㋫�ӭ����؊Ь�뵭�;$this->sql->set($���,$��);������;break;case 'group_add':$��=json_decode($this->in['param'],!0);����Ş�������ʝ��Ҥ��۴��Ļ��;if(!is_array($��)){show_json($this->L['error'],!1);}$��=$this->sql->get($���);foreach($�� as $��=>$�����){$��['group_info'][$��]=$�����;�������ц�⠯���;}$this->sql->set($���,$��);�ݭ��޸����;default:break;}}show_json($this->L['success']);�đ��������ӥ�ㄐ���;}public function init_install(){$�ܹ��=system_member::load_data();����ε��촌���;$�=$�ܹ��->get();��ŵ�����;foreach($� as $�ʈ��=>&$����){$����=hash_path();�����������������ͭ������;$this->_initDir($����);$����['path']=$����;$����['create_time']=time();��Ƶ����������잙��Ɛɚ�è�Ɉ�������֜�����ႏ�ɟ���܍����܆�;}$�ܹ��->reset($�);������;$����=explode(',',$this->config['setting_system']['new_group_folder']);���ꙑ��������ڏ��;$�ܹ��=system_group::load_data();$�=$�ܹ��->get();�ʇ�����;foreach($� as $�ʈ��=>&$����){$����=hash_path();�����������Ѭ�����𛮏流���ٌ��ŗ󘒭���ۇ���Ʋ̸��ǵ�Ȭ;$���=GROUP_PATH.$����.'/';foreach($���� as $�լ){mk_dir($���.'home/'.iconv_system($�լ));}$����['path']=$����;�����ùڋ�û����ԝ���܂����㊂�������筯�ӻ�������;$����['create_time']=time();}$�ܹ��->reset($�);}private function _initDir($���){$�����=array('home','recycle','data');$��=explode(',',$this->config['setting_system']['new_user_folder']);$�=USER_PATH.$���.'/';����݌����١�������麬���;foreach($����� as $���){mk_dir($�.$���);���⁡�;}foreach($�� as $���){mk_dir($�.'home/'.iconv_system($���));}fileCache::save($�.'data/config.php',$this->config['setting_default']);}}
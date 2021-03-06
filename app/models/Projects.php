<?php 
class Projects extends  Model 
{

    public $id ,$project_name ,$project_description ,$approved ,$project_manager ,$team_leader ,$je ,$customer;
    public function __construct($project='') {
        $table = 'projects';
        parent::__construct($table);
       
        if($project != '') {
          if(is_int($project)) {
            $u = $this->_db->findFirst('projects',['conditions'=>'id = ?', 'bind'=>[$project]]);
          } else {
            $u = $this->_db->findFirst('projects', ['conditions'=>'project_name = ?','bind'=>[$project]]);
          }
          if($u) {
            foreach($u as $key => $val) {
              $this->$key = $val;
            }
          }
        }
      }

      public function addproject($params)
      {
        $this->project_name =input::get('projectname');
        $this->project_description =input::get('description');
        $this->insert([
          'project_name'=>$this->project_name,
          'project_description'=> $this->project_description,
          'customer' => Users::currentLoggedInUser()->username
        ]);
      }

      public function viewUnassginedprojects()
      {
       $unassginedprojects  = $this->query("SELECT project_name,project_description,customer FROM projects");
       $unassginedprojects = $unassginedprojects->results();
       return $unassginedprojects ;
      }


}

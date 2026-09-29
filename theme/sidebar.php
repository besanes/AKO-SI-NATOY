<nav class="mt-2">

 <!-- HIPANAO SOLUTIONS  -->

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
           <li class="nav-header"> 
            <a href='<?php echo WEB_ROOT; ?>' class="nav-link <?php  echo ($title=='Home') ? "active" : 'na' ;?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                   </p>
            </a>
          </li>


     <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/Department' class="nav-link <?php  echo ($title=='Department Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-user-graduate"></i>
  <p style="font-weight: normal">
               Department
  </p>
  </a>
  </li>


   <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/Classrooms' class="nav-link <?php  echo ($title=='Classrooms Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-user-graduate"></i>
  <p style="font-weight: normal">
               Classrooms
  </p>
  </a>
  </li>      
  
  <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/scheduleday/index.php' class="nav-link <?php  echo ($title=='Sched Day Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-user-graduate"></i>
  <p style="font-weight: normal">
               Sched Day
  </p>
  </a>
  </li>   
  
  <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/schedtime/index.php' class="nav-link <?php  echo ($title=='Sched Time Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-user-graduate"></i>
  <p style="font-weight: normal">
               Sched Time
  </p>
  </a>
  </li>  
  
  <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/instructor/index.php' class="nav-link <?php  echo ($title=='instructor Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-user-graduate"></i>
  <p style="font-weight: normal">
              INSTRUCTOR
  </p>
  </a>
  </li>

  <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/setschedule/index.php' class="nav-link <?php  echo ($title=='setschedule Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-user-graduate"></i>
  <p style="font-weight: normal">
               Set Schedule
  </p>
  </a>
  </li>  


  <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/student' class="nav-link <?php  echo ($title=='Student Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-user-graduate"></i>
  <p style="font-weight: normal">
                Student
  </p>
  </a>
  </li>

  <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/course' class="nav-link <?php  echo ($title=='Course Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-book"></i>
  <p style="font-weight: normal">
                Course
  </p>
  </a>
  </li>

  

  
  

  <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/enrollment/index.php' class="nav-link <?php  echo ($title=='Enrollment') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-clipboard-list"></i>
  <p style="font-weight: normal">
                Enrollment
  </p>
  </a>
  </li>



  <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/subject' class="nav-link <?php  echo ($title=='Subject Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-clipboard-list"></i>
  <p style="font-weight: normal">
                Subject
  </p>
  </a>
  </li>

 <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/grades' class="nav-link <?php  echo ($title=='grades Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-clipboard-list"></i>
  <p style="font-weight: normal">
               Grades

  </p>
  </a>
  </li>

<li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/employee' class="nav-link <?php  echo ($title=='Employee Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-clipboard-list"></i>
  <p style="font-weight: normal">
               Employee

  </p>
  </a>
  </li>  
  <li class="nav-item"> 
  <a href='<?php echo WEB_ROOT; ?>module/cashier' class="nav-link <?php  echo ($title=='cashier Module') ? "active" : 'na' ;?>">
  <i class="nav-icon fa fa-clipboard-list"></i>
  <p style="font-weight: normal">
               cashier

  </p>
  </a>
  </li>  
  
  

          <li class="nav-item has-treeview">
           
            <a href="#" class="nav-link <?php  echo ($title=='User Module' || $title=='User Type' ) ? "active" : 'na' ;?>">
              <i class="fas fa-cog"></i>
              <p>
                Account Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href='<?php echo WEB_ROOT; ?>module/user/' class="nav-link">
                  <i class="nav-icon fa fa-users"></i>
                  <p>Manage User Accounts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href='<?php echo WEB_ROOT; ?>module/usertype/' class="nav-link">
                  <i class="nav-icon fa fa-key"></i>
                  <p>Manage User Type</p>
                </a>
              </li>    
            </ul>
          </li>
          
              
              
            </ul>
              
            
             

        </ul>
      </nav>
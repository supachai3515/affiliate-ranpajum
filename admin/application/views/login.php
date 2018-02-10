
<div class="container">
    <div class="row">
        <div class="col-md-offset-5 col-md-3">

    <form action="signin" method="POST" role="form">
            <div class="form-login">
            <h4>Login <?php echo $this->config->item('address_own'); ?></h4>
            <?php 
                  if($this->session->flashdata('msg') != ''){
                      echo '
                      <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        '.$this->session->flashdata('msg').'
                      </div>';
                  }
                  if($this->session->flashdata('success') != ''){
                      echo '
                       <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        '.$this->session->flashdata('success').'
                      </div>';
                  }    
              ?>  
            <input type="text" name="username" class="form-control input-sm chat-input" id="" placeholder="username" required>

            </br>
             <input type="password" name="password" class="form-control input-sm chat-input" id="" placeholder="password" required>
            </br>
            <div class="wrapper">
            <span class="group-btn">     
                <button type="submit" class="btn btn-primary">Signin</button>
            </span>
            </div>
            </div>
        </form>
        </div>
    </div>
</div>
<style type="text/css">
 @import url(http://fonts.googleapis.com/css?family=Roboto:400);
body {
  background-color:#fff;
  -webkit-font-smoothing: antialiased;
  font: normal 14px Roboto,arial,sans-serif;
}

.container {
    padding: 25px;
    position: fixed;
}

.form-login {
    background-color: #EDEDED;
    padding-top: 10px;
    padding-bottom: 20px;
    padding-left: 20px;
    padding-right: 20px;
    border-radius: 15px;
    border-color:#d2d2d2;
    border-width: 5px;
    box-shadow:0 1px 0 #cfcfcf;
}

h4 { 
 border:0 solid #fff; 
 border-bottom-width:1px;
 padding-bottom:10px;
 text-align: center;
}

.form-control {
    border-radius: 10px;
}

.wrapper {
    text-align: center;
}

</style>
<?php

function alert($data,$tipe){
    if(isset($data) && isset($tipe)) {
        echo '<div class="alert alert-'.$tipe; echo' alert-dismissible fade show" role="alert">';
        echo $data;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}
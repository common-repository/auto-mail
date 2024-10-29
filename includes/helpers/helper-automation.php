<?php

function AM_Automation() {
    return AM_Automation::get_instance();
}

function am_automation_run_automation($automation) {
    if($automation['type'] == 'users'){

    }else if($automation['type'] == 'posts'){

    }
}

/**
 * Run all users automation
 *
 * @since 2.2.2
 *
 * @param stdClass $automation The automation object
 *
 * @return bool
 */
function am_run_all_users_automation( $automation ) {

    // if(is_array(AM_Automation()->triggers[$automation['trigger']])){
    //     $prepareAction = AM_Automation()->actions[$automation['action']];
    //     $prepareAction->execute();
    // }

    // return true;

}
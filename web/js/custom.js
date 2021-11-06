
/**
 * global variables declaration
 * */
var base_url = document.getElementById('baseurl').value;
var action_id = document.getElementById('action-id').value;
var query_time;
var query_term;
var clicked_dom;
var click_time;
var page_first_view_moment;
var page_first_click_moment;
var page_active_time = 0;

var window_enter_moment;
var check_guest=document.getElementById('check-guest').value;
var search_result_number = 50;
var search_time = 1; // min
var suggestion_rate_count = 0;
var suggestion_rate_count_max = 5;

var modal_active = false;
var copied_text = "";
var modal_active_moment;
var modal_close_moment;
var total_modal_active_time = 0;
var total_copied_string = {};
var total_pasted_string = {};
var modal_view_iteration = 0;

var observation_modal_active = false;
var observation_modal_active_moment;
var observation_modal_close_moment;
var total_observation_modal_active_time = 0;
var observation_modal_view_iteration = 0;

var search_done = false;
var search_count = 0;
var search_result_click_count = 0;

var phase = document.getElementById('phase').value;

/**
 * code for disable browser back button option
 * */
if(check_guest == '1' && action_id !='feed'){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
    window.onhashchange=function(){window.location.hash="no-back-button";}
}

/**
 * function for storing idle users data
 */
function storeIdleUsers(){
    $.ajax({
        url: base_url+"/customajax/storeidleusers",
        type: "post",
        dataType: "json",
        success: function(response){
        },
        error: function(){
            console.log('error');
        }
    });
}

/**
 * function to set Custom Search Complete Cookie
 */
function setCustomSearchCompleteCookie(){

    console.log(search_result_click_count);
    if(search_done && search_result_click_count > 0){
        if(phase == 2){
            if(modal_view_iteration > 0 && observation_modal_view_iteration > 0){
                storeSuggestionModalTraceData();
            }else{
                storeIdleUsers();
                alert("WARNING: \n You have not seen previous users suggestions and experience during their search on the same topic. \n You can do that by clicking the buttons on top of this page.");
                $('#modal-active-button').addClass('btn-danger');
                $('#observation-modal-active-button').addClass('btn-danger');
            }
        }else{
            document.cookie = "custom_search_complete=custom_search_complete; path=/";
            window.location.href = base_url+'/answers/withsearch';
        }
    }else{
        storeIdleUsers();
        $('#bcs-searchbox').focus();
        alert("WARNING: \n It seems that you were IDLE in this task. \n It is mandatory to search and try to learn about the given topic. \n Click on relevant web page links that appear in the search results to learning about the topic.. \n Search using the search box only. \n If IDLE behavior is detected, you will not proceed to next step.");
    }
}

/**
 * fuction for checking a child is inside a parent
 * @param child
 * @param parent
 * @returns {boolean}
 */
function checkDomParent(child,parent){
    if(child.tagName != 'A'){
        return false;
    }
    var node = child.parentNode;
    while (node != null) {
        if (node.className == parent) {
            return true;
        }
        node = node.parentNode;
    }
    return false;
}

/**
 * fuction for finding a parent of a child
 * @param child
 * @param parent
 * @returns {boolean}
 */
function findParent(child,parent){
    if(child.tagName != 'A'){
        return false;
    }
    var node = child.parentNode;
    while (node != null) {
        if (node.className == parent) {
            return node;
        }
        node = node.parentNode;
    }
    return false;
}

/**
 * fuction for finding a child number inside parent
 * @param node
 * @returns {number}
 */
function findChildPosition(node){
    var i = 0;
    while( (node = node.previousSibling) != null ){i++};
    return i+1;
}

/**
 * function for generating suggestion pop up content
 * */
function suggestionFeedPopUpContentGenerate(){
    $.ajax({
        url: base_url+"/customajax/feedpopup",
        type: "post",
        dataType: 'html',
        success: function(response){
            $('#suggestion-feed-popup-body').html(response);
            observationPopUpContentGenerate();
        },
        error: function(){
            console.log('error');
        }
    });
}

/**
 * function for generating observation pop up content
 * */
function observationPopUpContentGenerate(){
    $.ajax({
        url: base_url+"/customajax/observationpopup",
        type: "post",
        dataType: 'html',
        success: function(response){
            $('#observation-popup-body').html(response);
        },
        error: function(){
            console.log('error');
        }
    });
}

/**
 * function for collecting and storing custom search data
 * @param event
 */
function collectAndStoreSearchData(event){
    if(query_term ==''){
        alert('Please enter search query for searching');
    }else{
        if(event == 'search_click'){
            var search_data = {'event':event, 'query_term': query_term, 'query_time':query_time, 'serp_rank': 0}
        }else if(event == 'result_link_click'){
            var page_url = clicked_dom.href;
            var page_title = clicked_dom.innerHTML;
            var p_element = $(clicked_dom).closest('li').find('p');
            var page_description = p_element.show().html();
            var page_number = $('.bcs-current-page').html();
            var clicked_dom_parent = findParent(clicked_dom,'bcs-result bcs-result-web');
            var clicked_result_position = findChildPosition(clicked_dom_parent);
            var serp_rank = (page_number - 1) * search_result_number + clicked_result_position;
            search_data = {'event':event,'query_term': query_term, 'query_time':query_time, 'click_time': click_time, 'page_url':page_url, 'page_title':page_title, 'page_description':page_description,'serp_rank': serp_rank}
        }
        console.log(search_data);
        $.ajax({
            url: base_url+"/customajax/storesearchdata",
            type: "post",
            dataType: 'json',
            data: search_data,
            success: function(response){
                console.log(response);
                if(event == 'search_click'){
                    search_done = true;
                    search_count = search_count + 1;
                }else if(event == 'result_link_click'){
                    search_result_click_count = search_result_click_count + 1;
                }
            },error: function(){
                console.log('error');
            }
        });
    }
}

/**
 * function for colllecting and storing page viewed data
 * */
function collectAndStorePageView(){
    var page_url = window.location.href;
    var referrer = document.referrer;
    var page_view_data = {'page_url':page_url,'referrer':referrer,'time_viewed':page_first_view_moment,'time_clicked':page_first_click_moment,'stay_time':page_stay_time_in_seconds,'active_time':page_active_time};
    console.log(page_view_data);
    $.ajax({
        url: base_url+"/customajax/storepageviewed",
        type: "post",
        dataType: 'json',
        data: page_view_data,
        async : false,
        success: function(response){
            console.log(response);
        },error: function(){
            console.log('error');
        }
    });
}

/**
 * function for updating thumbcount and rating
 * @param img_type
 * @param suggestion_id
 */
function updateThumbcount(img_type,suggestion_id){

    suggestion_rate_count += 1;

    $.ajax({
        url: base_url+"/customajax/updatethumbcount",
        type: "post",
        dataType: 'json',
        data: {img_type:img_type, suggestion_id: suggestion_id},
        success: function(response){
            if(response !== 'false'){
                console.log(response);
                var thumbs_up_count = response['thumbs_up'];
                var rating = response.rating;
                var thumbs_down_count = response.thumbs_down;
                var thumbs_up_count_html = "#thumbs_up_count-" + suggestion_id;
                var thumbs_down_count_html = "#thumbs_down_count-" + suggestion_id;
                var rating_html = "#rating-" + suggestion_id;
                $(thumbs_up_count_html).html(thumbs_up_count);
                $(thumbs_down_count_html).html(thumbs_down_count);
                $(rating_html).html(rating);

                if(img_type == 'thumbs_up'){
                    $('#thumbs_down-'+suggestion_id).removeClass('disable_img');
                    $('#thumbs_down-'+suggestion_id).addClass('enable_img');
                    $('#thumbs_up-'+suggestion_id).removeClass('enable_img');
                    $('#thumbs_up-'+suggestion_id).addClass('disable_img');
                }else{
                    $('#thumbs_up-'+suggestion_id).removeClass('disable_img');
                    $('#thumbs_up-'+suggestion_id).addClass('enable_img');
                    $('#thumbs_down-'+suggestion_id).removeClass('enable_img');
                    $('#thumbs_down-'+suggestion_id).addClass('disable_img');
                }
            }else{
                console.log(response);
            }
        },
        error: function(){
            console.log('error');
        }
    });
}


/**
 * Function for updating thumb count and rating in suggestion feed section
 * @param clicked_id_str
 * @param action
 */
function updateThumbcountHtml(clicked_id_str,action){
    var res = clicked_id_str.split('-');
    var img_type = res[0];
    var suggestion_id = res[1];
    if($('#'+clicked_id_str).hasClass('enable_img') && (img_type == 'thumbs_up' || img_type == 'thumbs_down')){
        updateThumbcount(img_type,suggestion_id);
    }else if($('#'+clicked_id_str).hasClass('enable_img') && (img_type == 'thumbs_updemo' || img_type == 'thumbs_downdemo')){
        suggestion_rate_count += 1;
        if(img_type == 'thumbs_updemo'){
            $('#thumbs_downdemo-'+suggestion_id).removeClass('disable_img');
            $('#thumbs_downdemo-'+suggestion_id).addClass('enable_img');
            $('#thumbs_updemo-'+suggestion_id).removeClass('enable_img');
            $('#thumbs_updemo-'+suggestion_id).addClass('disable_img');
        }else{
            $('#thumbs_updemo-'+suggestion_id).removeClass('disable_img');
            $('#thumbs_updemo-'+suggestion_id).addClass('enable_img');
            $('#thumbs_downdemo-'+suggestion_id).removeClass('enable_img');
            $('#thumbs_downdemo-'+suggestion_id).addClass('disable_img');
        }
    }

    if(action == 'feed'){
        enableFinishButton();
    }

}

/**
 * function for keep tracking of binary search request count
 */
function updateBcsCount(){

    $.ajax({
        url: base_url+"/customajax/updatebcscount",
        type: "post",
        dataType: 'json',
        data: {bcs_req:1},
        success: function(response){
            if(response !== 'false'){
                console.log(response);
            }else{
                console.log(response);
            }
        },
        error: function(){
            console.log('error');
        }
    });
}

/**
 * function for enabling finish button in feed page
 */
function enableFinishButton(){
    if(suggestion_rate_count >= suggestion_rate_count_max){
        var proceed_post_url = base_url+'/suggestion/finish';
        var proceed_post_a = "<a class = 'btn btn-lg btn-success' href = "+ proceed_post_url +">Finish and Get Completion Code</a>";
        var proceed_post_search = document.getElementById('proceed-finish-btn-container');
        proceed_post_search.innerHTML = proceed_post_a;
        proceed_post_search.className +=' blink';
    }
}

/**
 * Function for storing user intaraction with suggestion modal during custom search
 */
function storeSuggestionModalTraceData(){
    $.ajax({
        url: base_url+"/customajax/suggestionmodaltrace",
        type: "post",
        dataType: 'json',
        data: {total_copied_string:total_copied_string, total_pasted_string: total_pasted_string, total_modal_active_time:total_modal_active_time , modal_view_iteration: modal_view_iteration},
        success: function(response){
            console.log(response);
            storeObservationModalTraceData();
        },
        error: function(){
            console.log('error');
        }
    });
}

/**
 * Function for storing user intaraction with Observation modal during custom search
 */
function storeObservationModalTraceData(){
    $.ajax({
        url: base_url+"/customajax/observationmodaltrace",
        type: "post",
        dataType: 'json',
        data: {total_observation_modal_active_time:total_observation_modal_active_time , observation_modal_view_iteration: observation_modal_view_iteration},
        success: function(response){
            console.log(response);
            document.cookie = "custom_search_complete=custom_search_complete; path=/";
            window.location.href = base_url+'/answers/withsearch';
        },
        error: function(){
            console.log('error');
        }
    });
}

/**
 * section for collecting page stay time and triggereing store page view section
 * */
$(window).on("unload", function(e) {
    if(check_guest == '1'){
        var page_finally_leave_moment = new Date();
        page_stay_time_in_seconds = (page_finally_leave_moment.getTime() - page_first_view_moment.getTime()) / 1000;
        console.log('page first view:'+page_first_view_moment+'page leave:' + page_finally_leave_moment+ 'page_stay_time:' + page_stay_time_in_seconds);
        collectAndStorePageView()
    }
});

/**
 * document load function
 * */
$(document).ready(function(e){

    if(check_guest == '1'){

        if(!navigator.cookieEnabled){
            alert("Your browser cookie is disabled at the moment. Please make it enable and retry the process from beginning")
        }

        page_first_view_moment = new Date();

        if(action_id == 'customsearch'){

            if(phase == 2){
                alert("NOTE: \n Please see previous users suggestions and experience during their search on the same topic. \n This may help to improve your search experience.");
                suggestionFeedPopUpContentGenerate();
            }
            $('#bcs-searchbox').focus();
            setTimeout(function(){
                var proceed_post_url = base_url+'/answers/withsearch';
                var proceed_post_a = "<a class = 'btn btn-lg btn-success' id='final-test-proceed-button' onclick=setCustomSearchCompleteCookie()>Proceed to Final Test</a>";
                var proceed_post_search = document.getElementById('proceed-post-search-btn-container');
                proceed_post_search.innerHTML = proceed_post_a;
                proceed_post_search.className +=' blink';
            }, 1000*60*search_time);
        }
        if(action_id == 'suggestioncreate'){
            $('#suggestion-suggestion').focus();
        }
    }
});

/**
 * section for mouseenter event
 * */
$(document).mouseenter(function () {
    if(check_guest == '1'){
        window_enter_moment = new Date();
    }
});

/**
 * section for mouseleave event
 * */
$(document).mouseleave(function () {
    if(check_guest == '1'){
        var window_leave_moment = new Date();
        var seconds_inside_window = (window_leave_moment.getTime() - window_enter_moment.getTime()) / 1000;
        prev_page_active_time = page_active_time;
        page_active_time += seconds_inside_window;
        console.log('mouse leave event- in moment:'+ window_enter_moment + 'out moment:'+ window_leave_moment + 'prev active time:' + prev_page_active_time+ 'total active time:' + page_active_time);
    }

});


/**
 *  all click event
 */
$(document).click(function(e) {

    if(check_guest == '1'){

        if(!navigator.cookieEnabled){
            alert("Your browser cookie is disabled at the moment. Please make it enable and retry the process from beginning");
            return false;
        }

        page_first_click_moment = new Date();
        clicked_dom = e.target;
        var clicked_dom_class = clicked_dom.className;
        var clicked_id_str = clicked_dom.id;

        if(action_id == 'customsearch'){
            //$('#bcs-searchbox').focus();
            /**
             * section for collecting and storing serach data start
             * */
            var check_value = checkDomParent(clicked_dom,'bcs-result bcs-result-web');
            console.log(check_value);
            if(clicked_dom_class == 'bcs-searchbox-submit' || check_value){
                if(clicked_dom_class == 'bcs-searchbox-submit'){
                    query_term = document.getElementById('bcs-searchbox').value;
                    query_term = query_term.trim();
                    query_time = new Date();
                    var event = 'search_click';
                }else{
                    click_time = new Date();
                    event = 'result_link_click';
                }
                collectAndStoreSearchData(event);
            }else{
                /**
                 * update binary search req count for pagiantion start
                 */
                var check_parent = checkDomParent(clicked_dom,'bcs-pagination');
                if(check_parent){
                    updateBcsCount();
                }
                /**
                 * update binary search req count for pagiantion end
                 */
            }
            /**
             * section for collecting and storing serach data end
             * */


            if(phase == 2){ // for the second part

                /**
                 * Suggestion modal activating, closing and rating activity tracing start
                 */

                //opening suggestion modal
                if(modal_active == false && clicked_id_str=='modal-active-button'){
                    modal_active_moment = new Date();
                    modal_active = true;
                    modal_view_iteration++;
                }

                //closing suggestion modal
                if(modal_active == true && clicked_id_str=='modal-close-button'){
                    modal_active = false;
                    modal_close_moment = new Date();
                    var seconds_inside_modal_active_and_close = (modal_close_moment.getTime() - modal_active_moment.getTime()) / 1000;
                    total_modal_active_time += seconds_inside_modal_active_and_close;
                    console.log(total_modal_active_time);
                }

                //rating in suggestion modal using thumbs up and down
                if(modal_active == true && (clicked_dom.parentNode.className == 'thumbs-up-image' || clicked_dom.parentNode.className == 'thumbs-down-image')){
                    updateThumbcountHtml(clicked_id_str,action_id);
                }

                //event for copying from suggestion modal
                $(".sug-text").bind('copy', function() {
                    copied_text = window.getSelection().toString();
                    if (!(copied_text in total_copied_string)){
                        total_copied_string[copied_text] = this.id;
                    }
                });

                //event for pasting suggestion text in custom search input box
                $(".bcs-searchbox").bind('paste', function() {
                    if(copied_text != "" && !(copied_text in total_pasted_string)){
                        total_pasted_string[copied_text] = total_copied_string[copied_text];
                        console.log(total_copied_string);
                        console.log(total_pasted_string);
                    }
                });


                //opening observation modal
                if(observation_modal_active == false && clicked_id_str=='observation-modal-active-button'){
                    observation_modal_active_moment = new Date();
                    observation_modal_active = true;
                    observation_modal_view_iteration++;
                }

                //closing observation modal
                if(observation_modal_active == true && clicked_id_str=='observation-modal-close-button'){
                    observation_modal_active = false;
                    observation_modal_close_moment = new Date();
                    var seconds_inside_observation_modal_active_and_close = (observation_modal_close_moment.getTime() - observation_modal_active_moment.getTime()) / 1000;
                    total_observation_modal_active_time += seconds_inside_observation_modal_active_and_close;
                    console.log(total_observation_modal_active_time);
                }

                /**
                 * Suggestion modal activating, closing, copy , pasting  and rating activity tracing end
                 */
            }
        }

        /**
         * section for updating thumbcount and rating start
         * */
        if(action_id == 'feed'){
            updateThumbcountHtml(clicked_id_str,action_id);
        }
        /**
         * section for updating thumbcount and rating end
         * */

    }
});

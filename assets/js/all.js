//var base_url='http://incubator.gq';
var base_url='http://localhost/incubator-v1';

// Write idea to database on Enter key
if (document.getElementById('clickbox')!=null) {
document.getElementById('clickbox').addEventListener('keydown', (evt) => {
    if (evt.keyCode === 13) {
        evt.preventDefault();
        console.log(document.title);
        if (document.title==='Incubator') {
            appendidea();
        };
        if (document.title==='Groups | Incubator') {
            appendgroup();
        };
    };
});
}

// Writes idea to database
function appendidea() {
    $member_id=Number(document.getElementById('member-id').innerHTML);
    if (document.getElementById('clickbox').innerHTML !== "") {
        jQuery.ajax({
            type: "POST",
            url: base_url+'/include/functions/append_idea.php',
            dataType: 'json',
            data: {member_id: $member_id, title: document.getElementById('clickbox').innerHTML},
            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    $(".content-rows").load(" .content-rows > *");
                }
                else {
                    console.log(obj.error);
                }
            }
        });
        document.getElementById('clickbox').innerHTML="";
    };
};


// Delete the idea
function deleteidea($id) {
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/delete_idea.php',
        dataType: 'json',
        data: {id: $id},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                $(".content-rows").load(" .content-rows > *");
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

// Open the Modal
function openModal() {
  document.getElementById("myModal").style.display = "block";
}

// Close the Modal
function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

// Fetches contents for the ideas on lightbox open
function currentSlide($id,$type,$memberid) {
    $(".modal-content").load(base_url+'/include/functions/'+$type+'_description.php', {'id': $id,'memberid': $memberid});
}

function updateidea($id) {
    $desc=document.getElementsByClassName("ql-editor")[0].innerHTML;
    jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/update_idea.php',
    dataType: 'json',
    data: {id: $id, description: $desc},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      yourVariable = obj.result;
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
    document.getElementById('save'+$id).innerHTML="Saved!";
    setTimeout(function() {
        document.getElementById('save'+$id).innerHTML="Save";
}, 2000);
}

//tabination
function opentab(evt, tabName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

//Add a friend
function appendfriend($member_id,$friend_id) {
      jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/append_friend.php',
    dataType: 'json',
    data: {member_id: $member_id,friend_id: $friend_id},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      yourVariable = obj.result;
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
    document.getElementById($member_id+','+$friend_id).innerHTML="Added!";
    document.getElementById($member_id+','+$friend_id).style.cursor="auto";
    document.getElementById($member_id+','+$friend_id).setAttribute("onclick", "");
}

//Accept friend request
function updatefriend($member_id,$friend_id) {
      jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/update_friend.php',
    dataType: 'json',
    data: {member_id: $member_id,friend_id: $friend_id},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      yourVariable = obj.result;
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
    document.getElementById('reqrec'+$member_id+','+$friend_id).innerHTML="Accepted!";
    document.getElementById('reqrec'+$member_id+','+$friend_id).style.cursor="auto";
    document.getElementById('reqrec'+$member_id+','+$friend_id).setAttribute("onclick", "");
}

// Writes group to database
function appendgroup() {
    $member_id=document.getElementsByName('memberid')[0].innerHTML;
    if (document.getElementById('clickbox').innerHTML !== "") {
      jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/append_group.php',
    dataType: 'json',
    data: {member_id: $member_id, title: document.getElementById('clickbox').innerHTML},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                    $(".content-rows").load(" .content-rows > *");
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
          document.getElementById('clickbox').innerHTML="";
      };
};

// Delete the group
function deletegroup($id) {
      jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/delete_group.php',
    dataType: 'json',
    data: {id: $id},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                    closeModal();
                    $(".content-rows").load(" .content-rows > *");
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
}

//Update group with new member
function addtogroup($groupid,$memberid) {
    jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/addto_group.php',
    dataType: 'json',
    data: {groupid: $groupid, memberid: $memberid},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      yourVariable = obj.result;
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
    document.getElementById($groupid+','+$memberid).innerHTML="";
}

//Update idea with new member
function addfriendtoidea($ideaid,$memberid) {
    jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/add_friend_to_idea.php',
    dataType: 'json',
    data: {ideaid: $ideaid, memberid: $memberid},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      yourVariable = obj.result;
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
    document.getElementById($ideaid+','+$memberid).innerHTML="";
}

//Update idea with new group
function addgrouptoidea($ideaid,$groupid,$group_title) {
    jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/add_group_to_idea.php',
    dataType: 'json',
    data: {ideaid: $ideaid, groupid: $groupid},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      yourVariable = obj.result;
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
    $child_elem=document.createElement("A");
    $child_elem.className="rows";
    $child_elem.innerHTML=$group_title;
    document.getElementById("share-group-add").appendChild($child_elem);
    $remove_elem=document.getElementById("dropdown-group"+$groupid);
    $remove_elem.parentNode.removeChild($remove_elem);
}

/* Dropdown */
function dropdown($name) {
  document.getElementById($name).classList.toggle("show");
}

function filterFunction($name,$input) {
  var input, filter, ul, li, a, i;
  input = document.getElementById($input);
  filter = input.value.toUpperCase();
  div = document.getElementById($name);
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

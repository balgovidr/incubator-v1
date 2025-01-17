//var base_url='http://incubator.gq';
var base_url='http://localhost/incubator-v1';

// Write idea to database on Enter key
if (document.getElementById('clickbox')!=null) {
document.getElementById('clickbox').addEventListener('keydown', (evt) => {
    if (evt.keyCode === 13) {
        evt.preventDefault();
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
                    $data=JSON.parse(JSON.stringify(obj));
                    //Looping through the received array of temporary member emails and sending them emails
                    //The first row of the array is the Idea Id
                    $IdeaId = $data[0];
                    var i;
                    for (i = 1; i < $data.length; i++) {
                        InviteToIdea($data[i], $IdeaId);
                    }
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
    $id=parseInt($id);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/delete_idea.php',
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
    if ($type=='idea') {
        document.getElementById("closeModal").setAttribute("onclick","closeModal(),updateidea("+$id+")");
    };
}

function updateidea($id) {
    $id=parseInt($id);
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
    $member_id=parseInt($member_id);
    $friend_id=parseInt($friend_id);
      jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/append_friend.php',
    dataType: 'json',
    data: {member_id: $member_id,friend_id: $friend_id},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                    $remove_elem=document.getElementById("dropdown-member-icon"+$friend_id);
                    document.getElementsByClassName("idea-dropdown").removeChild($remove_elem);
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
    $member_id=parseInt($member_id);
    $friend_id=parseInt($friend_id);
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
    $id=parseInt($id);
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
function addtogroup($groupid,$memberid,$membername) {
    $groupid=parseInt($groupid);
    $memberid=parseInt($memberid);
    jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/addto_group.php',
    dataType: 'json',
    data: {groupid: $groupid, memberid: $memberid},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                    $( "#group-member-title" ).after( '<div class="rows" id="member'+$memberid+'"><a class="adjust-size">'+$membername+'</a><a class="fixed-size icon" onclick="removememberfromgroup('+$groupid+','+$memberid+')"><i class="fas fa-user-minus"></i></a></div>' );
                    $remove_elem=document.getElementById("dropdown-friend"+$memberid);
                    document.getElementById("friend-dropdown").removeChild($remove_elem);
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
}

//Update idea with new member
function addfriendtoidea($ideaid,$memberid,$friendname) {
    $ideaid=parseInt($ideaid);
    $memberid=parseInt($memberid);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/add_friend_to_idea.php',
        dataType: 'json',
        data: {ideaid: $ideaid, memberid: $memberid},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                $( "#share-friend-title" ).after( '<div class="rows" id="friend'+$memberid+'"><a class="adjust-size">'+$friendname+'</a><a class="fixed-size icon" onclick="removefriendfromidea('+$ideaid+','+$memberid+')"><i class="fas fa-user-minus"></i></a></div>' );
                $remove_elem=document.getElementById("dropdown-idea"+$memberid);
                document.getElementById("idea-dropdown").removeChild($remove_elem);
                $remove_elem=document.getElementById("dropdown-idea"+$groupid);
                document.getElementById("group-dropdown").removeChild($remove_elem);
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

//Remove member from idea
function removefriendfromidea($ideaid,$friendid) {
    $ideaid=parseInt($ideaid);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/remove_friend_from_idea.php',
        dataType: 'json',
        data: {ideaid: $ideaid, friendid: $friendid},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                $remove_elem=document.getElementById("friend"+$friendid);
                document.getElementById("Share").removeChild($remove_elem);
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

//Remove member from group
function removememberfromgroup($groupid,$memberid) {
    $groupid=parseInt($groupid);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/remove_member_from_group.php',
        dataType: 'json',
        data: {groupid: $groupid, memberid: $memberid},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                $remove_elem=document.getElementById("member"+$memberid);
                document.getElementById("Members").removeChild($remove_elem);
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

//Update idea with new group
function addgrouptoidea($ideaid,$groupid,$group_title) {
    $ideaid=parseInt($ideaid);
    $groupid=parseInt($groupid);
    jQuery.ajax({
    type: "POST",
    url: base_url+'/include/functions/add_group_to_idea.php',
    dataType: 'json',
    data: {ideaid: $ideaid, groupid: $groupid},
    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                    $( "#share-group-title" ).after( '<div class="rows" id="group'+$groupid+'"><a class="adjust-size">'+$group_title+'</a><a class="fixed-size icon" onclick="removegroupfromidea('+$ideaid+','+$groupid+')"><i class="fas fa-minus-circle"></i></a></div>' );
                    $remove_elem=document.getElementById("dropdown-group"+$groupid);
                    document.getElementById("group-dropdown").removeChild($remove_elem);

                    $data=JSON.parse(JSON.stringify(obj));
                    //Looping through the received array of temporary member emails and sending them emails
                    //The first row of the array is the Idea Id
                    $IdeaId = $data[0];
                    var i;
                    for (i = 1; i < $data.length; i++) {
                        InviteToIdea($data[i], $IdeaId);
                    }
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
}

//Remove group from idea
function removegroupfromidea($ideaid,$groupid) {
    $ideaid=parseInt($ideaid);
    $groupid=parseInt($groupid);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/remove_group_from_idea.php',
        dataType: 'json',
        data: {ideaid: $ideaid, groupid: $groupid},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                $remove_elem=document.getElementById("group"+$groupid);
                document.getElementById("Share").removeChild($remove_elem);
            }
            else {
                console.log(obj.error);
            }
        }
    });
}


//Vote for an idea
function VoteIdea($IdeaId,$VoteType) {

    $IdeaId=parseInt($IdeaId);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/vote_idea.php',
        dataType: 'json',
        data: {IdeaId: $IdeaId, VoteType: $VoteType},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                $("#row-"+$IdeaId).load(" #row-"+$IdeaId+" > *");
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

//Confirm email
function ConfirmEmail($MemberUsername) {
    jQuery.ajax({
        type: "POST",
        url: base_url+'/assets/mailer/confirm_email.php',
        dataType: 'json',
        data: {MemberUsername: $MemberUsername},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

//Toggle display of element from none to flex
function ToggleDisplay($ElementId,$DisplayType) {
    var x = document.getElementById($ElementId);
    if (x.style.display === "none") {
      x.style.display = $DisplayType;
    } else {
      x.style.display = "none";
    }
}
//Toggle display of element from none to flex, some the other way around
function ToggleDisplay2($ElementId,$DisplayType) {
    var x = document.getElementById($ElementId);
    if (x.style.display == $DisplayType) {
      x.style.display = "none";
    } else {
      x.style.display = $DisplayType;
    }
}
//Needs another bit of code to make sure that all styles on the menu is removed when back to normal
window.onresize = ResetDisplayMenu;
function ResetDisplayMenu() {
    //resize just happened, pixels changed
    if (window.screen.width>600) {
        var x = document.getElementById('menu');
        x.style="";
    }
  };

//Setting the default share option for a user based on the settings chosen for an idea
function SetDefaultShare($IdeaId) {
    $IdeaId=parseInt($IdeaId);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/set_default_share.php',
        dataType: 'json',
        data: {IdeaId: $IdeaId},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

function Invite() {
    $InvitationEmail=document.getElementById("invite-email").value;
    document.getElementById("invite-email").value='Sent!';
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/invite.php',
        dataType: 'json',
        data: {InvitationEmail: $InvitationEmail},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

/* Create a new temporary member if there isn't already one and invite them to the idea */
function CreateAndInviteToIdea($IdeaId) {
    $InvitationEmail=document.getElementById("invite-email").value;
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/create_temp_member.php',
        dataType: 'json',
        data: {InvitationEmail: $InvitationEmail},
        success: function (obj) {
            if (isNaN(obj)==false) {
                document.getElementById("invite-email").value='Sent!';
                AddTempMemberToIdea(obj, $IdeaId, $InvitationEmail);
                AddTempMemberToFriend($InvitationEmail);
            }
        }
    });
}

function AddTempMemberToFriend($TempMemberEmail) {
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/add_temp_member_to_friend.php',
        dataType: 'json',
        data: {TempMemberEmail: $TempMemberEmail},
        success: function (obj) {}
    });
}

function InviteToIdea($InvitationEmail, $IdeaId) {
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/invite_to_idea.php',
        dataType: 'json',
        data: {InvitationEmail: $InvitationEmail, IdeaId: $IdeaId},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

function AddTempMemberToIdea($TempMemberId, $IdeaId, $InvitationEmail) {
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/add_temp_member_to_idea.php',
        dataType: 'json',
        data: {TempMemberId: $TempMemberId, IdeaId: $IdeaId},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                $( "#share-friend-title" ).after( '<div class="rows" id="temp-member'+$TempMemberId+'"><a class="adjust-size">'+$InvitationEmail+'</a><a class="fixed-size icon" onclick="RemoveTempMemberFromIdea('+$IdeaId+','+$TempMemberId+')"><i class="fas fa-user-minus"></i></a></div>' );
                $remove_elem=document.getElementById("dropdown-idea-temp-member-"+$TempMemberId);
                document.getElementById("idea-dropdown").removeChild($remove_elem);
                InviteToIdea($InvitationEmail,$IdeaId);
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

//Remove temporary member from idea
function RemoveTempMemberFromIdea($IdeaId,$TempMemberId) {
    $IdeaId=parseInt($IdeaId);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/remove_temp_member_from_idea.php',
        dataType: 'json',
        data: {IdeaId: $IdeaId, TempMemberId: $TempMemberId},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                $remove_elem=document.getElementById("temp-member-"+$TempMemberId);
                document.getElementById("Share").removeChild($remove_elem);
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

//Update group with a temp member
function AddTempMemberToGroup($GroupId,$TempMemberId,$TempMemberEmail) {
    $GroupId=parseInt($GroupId);
    $TempMemberId=parseInt($TempMemberId);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/add_temp_member_to_group.php',
        dataType: 'json',
        data: {GroupId: $GroupId, TempMemberId: $TempMemberId},
        success: function () {
            $( "#group-member-title" ).after( '<div class="rows" id="temp-member-'+$TempMemberId+'"><a class="adjust-size">'+$TempMemberEmail+'</a><a class="fixed-size icon" onclick="RemoveTempMemberFromGroup('+$GroupId+','+$TempMemberId+')"><i class="fas fa-user-minus"></i></a></div>' );
            $remove_elem=document.getElementById("dropdown-temp-member-"+$TempMemberId);
            document.getElementById("friend-dropdown").removeChild($remove_elem);
        }
    });
}

//Remove temporary member from group
function RemoveTempMemberFromGroup($GroupId,$TempMemberId) {
    $GroupId=parseInt($GroupId);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/remove_temp_member_from_group.php',
        dataType: 'json',
        data: {GroupId: $GroupId, TempMemberId: $TempMemberId},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
                $remove_elem=document.getElementById("temp-member-"+$TempMemberId);
                document.getElementById("Members").removeChild($remove_elem);
            }
            else {
                console.log(obj.error);
            }
        }
    });
}

//Convert a temp member to a permanent member in a friend's ideas and groups
function TempMemberToPermMember($Member1Id,$Member2Id) {
    $Member1Id=parseInt($Member1Id);
    $Member2Id=parseInt($Member2Id);
    jQuery.ajax({
        type: "POST",
        url: base_url+'/include/functions/temp_member_to_perm_member.php',
        dataType: 'json',
        data: {Member1Id: $Member1Id, Member2Id: $Member2Id},
        success: function (obj, textstatus) {
            if( !('error' in obj) ) {
            }
            else {
                console.log(obj.error);
            }
        }
    });
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

// Direct to add_item page
function toAddItem() {
    location.replace("\\SeventeenJuly\\staff\\store\\add_items");
}


// Check if checktbox options is valid
function checkBoxCheck(id) {
  var msg = '<i class="fas fa-exclamation-triangle"></i><p id="warning">No shoes are selected!</p>'

  // If at least one checkbox checked
  if ($('input:checkbox[name="shoesname[]"]:checked').length) {
    if (id==="remove_shoes") {
      removeShoes();
    } else if (id==="promotion") {
      if (checkPromo()){
        return true;
      } else {
        return false;
      }
    } else if (id==="remove_promo") {
      if (removePromo()){
        removeconfirm();
      } else {
        return false;
      }
    }
    
  } else {
    var confirmBox = $("#confirm");
    confirmBox.find(".message").html(msg);
    confirmBox.find(".yes").click(function() {
      confirmBox.hide();
    });
    confirmBox.show();
    return false;
  } 
}

// Return true if shoes are not in promotion
function checkPromo() {
  var msg = '<i class="fas fa-exclamation-triangle"></i><p id="warning">One or more shoes are in promotion!</p>'
  var inputs = $("#shoes input");
    checked = [];
    diff = [];
  for (var i = 0, max = inputs.length; i < max; i += 1) {
   // Take only those inputs which are checkbox
   if (inputs[i].type === "checkbox" && inputs[i].checked) {
      checked.push(inputs[i].value);
   }
  }

  // for each shoes checked, check if it is in promotion
  $.each(checked, function(key, value) {
    var index = $.inArray(value, promo_names);
    // Add to array if in promotion
    if( index != -1 ) {
        diff.push(value);
      }});

    if (diff.length === 0) {
      return true;
    } else {
      var confirmBox = $("#confirm");
      confirmBox.find(".message").html(msg);
      confirmBox.find(".yes").click(function() {
        confirmBox.hide();
      });
      confirmBox.show();
      return false;
    };
}

// Return true if shoes are in promotion
function removePromo() {
  var msg = '<i class="fas fa-exclamation-triangle"></i><p id="warning">Some shoes are not in promotion!</p>'
  var inputs = $("#shoes input");
    checked = [];
    diff = [];
  for (var i = 0, max = inputs.length; i < max; i += 1) {
   // Take only those inputs which are checkbox
   if (inputs[i].type === "checkbox" && inputs[i].checked) {
      checked.push(inputs[i].value);
   }
  }

  // for each shoes checked, check if it is in promotion
  $.each(checked, function(key, value ) {
    var index = $.inArray(value, promo_names);
    
    // Add to array if in promotion
    if( index === -1 ) {
        diff.push(value);
      }});
      
    if (diff.length === 0) {
      return true;
    } else {
      var confirmBox = $("#confirm");
      confirmBox.find(".message").html(msg);
      confirmBox.find(".yes").click(function() {
        confirmBox.hide();
      });
      confirmBox.show();
      return false;
    };
}

function removeShoes() {
  var msg = '<i class="fas fa-exclamation-triangle"></i><p id="warning">Are you sure to remove the following shoes?</p>'
  var inputs = $("#shoes input");
  var shoes = "";

  for (var i = 0, max = inputs.length; i < max; i += 1) {
   // Take only those inputs which are checkbox
   if (inputs[i].type === "checkbox" && inputs[i].checked) {
      // Add selected shoes
      shoes += '<p>' + inputs[i].value + '</p>';
   }
  }
      var confirmBox = $("#remove-confirm");
      confirmBox.find(".remove-message").html(msg);
      // Show selected shoes list
      confirmBox.find(".remove-shoes-list").html(shoes);
      confirmBox.find(".remove-yes").click(function() {
        confirmBox.hide();
      });
      confirmBox.find(".remove-no").click(function() {
        confirmBox.hide();
      });
      confirmBox.show();
}

// Return true if shoes are in promotion
function removeconfirm() {
  var msg = '<i class="fas fa-exclamation-triangle"></i><p id="warning">Are you sure to remove the following shoes from promotion?</p>'
  var inputs = $("#shoes input");
  var shoes = "";

  for (var i = 0, max = inputs.length; i < max; i += 1) {
   // Take only those inputs which are checkbox
   if (inputs[i].type === "checkbox" && inputs[i].checked) {
      // Add selected shoes
      shoes += '<p>' + inputs[i].value + '</p>';
   }
  }
      var confirmBox = $("#promo-confirm");
      confirmBox.find(".promo-message").html(msg);
      // Show selected shoes list
      confirmBox.find(".promo-shoes-list").html(shoes);
      confirmBox.find(".promo-yes").click(function() {
        confirmBox.hide();
      });
      confirmBox.find(".promo-no").click(function() {
        confirmBox.hide();
      });
      confirmBox.show();
}

$(".dropbtn").click(function(){
    let index = $(".dropbtn").index(this);
    $("#filter"+ index).slideToggle();
    })




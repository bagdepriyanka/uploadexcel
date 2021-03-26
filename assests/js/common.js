function setValues($id) {
    $.ajax({
        url: "setvalues.php?id=" + $id,
        success: function (result) {
            setvalue = JSON.parse(result);
            $("#id").val(setvalue.id);
            $("#task").val(setvalue.item_detail);
            $("#due_date").val(setvalue.due_date.trim().replace(' ', "T"));
            $(`input[name="status"][value="${setvalue.status}"]`).prop('checked', true);
        }
    });
    $("#add").hide();
    $("#edit").show();
    $("#status_div").show();
}

function clearForm() {
    $('#form_id').trigger("reset");
    $("#status_div").hide();
    $('#edit').hide();
    $("#add").show();
}

function updateTask() {
    // console.log($('form').serializeArray());
    var data = $("form").serializeArray().reduce(function (obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    //console.log(data);
    var request = $.ajax({
        url: "update.php",
        type: "POST",
        data: data,
        success: function (result) {
            console.log(result);
            window.location.reload();
        }
    });
}

function addTask() {
    // console.log($('form').serializeArray());
    var data = $("form").serializeArray().reduce(function (obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    // console.log(data);
    var request = $.ajax({
        url: "add.php",
        type: "POST",
        data: data,
        success: function (result) {
            console.log(result);
            window.location.reload();
        }
    });
}

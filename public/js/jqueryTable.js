
$(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click','.btn-edit',function(){
        let row = $(this).closest('tr');
        let id = row.find('td').eq(0).text().trim();
        let name = row.find('td').eq(2).text().trim();
        let price = row.find('td').eq(3).text().trim();
        let cate = row.find('td').eq(4).text().trim();

        // Get image src from img tag inside first <th>
        let picSrc = row.find('img').attr('src');

        $("#updateProduct").modal('show');

        $("#update_id").val(id);
        $("#delete_id").val(id);
        $("#update_name").val(name);
        $("#update_price").val(price);
        $("#update_cate").val(cate);

        // Set image preview
    $("#previewImage").attr("src", picSrc).removeClass("d-none");
    });

//     This cannot be use with image its only text 

//     $('#updateProduct').click(function(){
//         let id = $("#update_id").val();
//         let pic = $("#update_pic").val();
//         let name = $("#update_name").val();
//         let price = $("#update_price").val();
//         let cate = $("#update_cate").val();
 

//     $.post("/productUpdate",{
//         id : id,
//         pic : pic,
//         name : name,
//         price : price,
//         cate : cate

//     },function(data,status){
//         alert("User updated successfully");
//         window.location.href = "/table";
//     });

//    });

// Ajax for image
 // Handle update form submission
    $('#btnUpdateProduct').click(function (e) {
        e.preventDefault();

        // Collect data from form
        let id = $("#update_id").val();
        let name = $("#update_name").val();
        let price = $("#update_price").val();
        let cate = $("#update_cate").val();
        let fileInput = $('#imageInput')[0];

        // Create FormData object
        let formData = new FormData();
        formData.append('id', id);
        formData.append('name', name);
        formData.append('price', price);
        formData.append('category', cate);

        // Only append image if selected
        if (fileInput.files.length > 0) {
            formData.append('pic', fileInput.files[0]);
        }

        // Send AJAX request with image Update
        $.ajax({
            url: '/productUpdate',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                alert("Product updated successfully");
                window.location.href = "/products";
            },
            error: function (xhr) {
                alert("Error: " + xhr.responseText);
                console.error(xhr);
            }
        });
    });

    // Delete Ajax 

    $('#btnDeleteProduct').click(function(e){
        e.preventDefault();
        let id = $('#update_id').val();

        if(!confirm("Are you sure you want to delete this product?")) return;
        $.ajax({
            url:'/productDelete/'+id,
            type: 'post',
            data:{
                _method:'DELETE'
            },success : function(data){
                alert("Product Deleted Successfully!");
                window.location.href="/products";
            }
        });
    });

    // ----------------------- Category Update ajax
    $(document).on('click','.categoryUpdate',function(){
        let row = $(this).closest('tr');   
        let id = row.find('td').eq(0).text().trim();
        let name = row.find('td').eq(1).text().trim();  
        $('#cateName').val(name);
        $('#cateId').val(id);
        $('#categoryModalUpdate').modal('show');
    });
    $('#UpdateCategory').click(function(){
        let id= $('#cateId').val();
        let name= $('#cateName').val();
        $.post("/categoryUpdate",{
            id : id,
            name : name
        },function(data,status){
            alert("Category Updated Successfully!");
            window.location.href = "/products";
        });
    });
    $('#DeleteCategory').click(function(){
        let id= $('#cateId').val();
        let name= $('#cateName').val();
        $.post("/categoryDelete/"+id,
        function(data,status){
            alert("Category Deleted Successfully!");
            window.location.href = "/products";
        });
    });


    // ----------------Update Cashier
    $(document).on('click','.cashierUpdate',function(){
        let row = $(this).closest('tr');
        let id = row.find('td').eq(0).text().trim();
        let name = row.find('td').eq(1).text().trim();
        let email = row.find('td').eq(2).text().trim();
        let role = row.find('td').eq(3).text().trim();
        $("#id").val(id);
        $("#name").val(name);
        $("#email").val(email);
        $("#role").val(role);
        $("#cashierModalUpdate").modal('show');
    });
    $('#cashierUpdate').click(function(){
        let id = $("#id").val();
        let name = $("#name").val();
        let email = $("#email").val();
        let password = $("#password").val();
        let role = $("#role").val();
        $.post("/cashierUpdate",{
            id : id,
            name : name,
            email : email,
            password : password,
            role : role,
        },function(data,status){
            alert("Account Updated Successfully");
            window.location.href = "/cashiers";
        });
    });
    $('#cashierDelete').click(function(){
        let id = $('#id').val();
        if(!confirm("Are you sure you want to delete this account?")) return;
        $.post("cashierDelete/"+id,function(data,status){
            alert("Account Deleted Successfully");
            window.location.href = "/cashiers";
        });
    });








});

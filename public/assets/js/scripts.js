let RESULT = true;

const AllScript = {
    init: function(){
        NProgress.configure({ parent: '#pjax-container', showSpinner: true });
    },
    initCustomScripts: function(){
        // $(".custom-select2").select2({
        //     theme: "bootstrap-5",
        // });
        // $(".custom-select2").on("select2:open", function (e) {
        //     $(".select2-search__field").get(0).focus();
        // });
    },
    loader: function(type = true){
        const SubmitBtn =  $('#submit-button');
        if(type){
            NProgress.start();
            if (SubmitBtn) {
                SubmitBtn.attr('disabled', true);
            }
        }else{
            NProgress.done();
            if (SubmitBtn) {
                SubmitBtn.attr('disabled', false);
            }
        }
    },
    submitForm:  function(form, actionUrl, method = 'POST'){ 
        let addForm = new FormData(form[0]);
        let result = false;
        AllScript.loader(true);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: method, 
            url: actionUrl,
            data: addForm,
            contentType: false,
            processData: false,
            success: (response) => {
                AllScript.loader(false);
                toastr.success(response.message || 'Request successful');
                result = true;
            },
            error: (response) => {
                AllScript.loader(false);
                if (response.status === 422) {
                    // Validation error occurred
                    let errors = response.responseJSON.errors;
                    $.each(errors, (field, messages) => {
                        toastr.error(messages[0]);
                    });
                }else if(response.status === 402) {
                    toastr.error(errors.messages); 
                } else {
                    toastr.error('An error occurred. Please try again.'); 
                }                
                result = false;
            }
        });
        return result;
    },
    submitFormAsync: async function (form, actionUrl, method = 'POST') { 
        let addForm = new FormData(form[0]);
        AllScript.loader(true);
        try {
            const response = await $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: method,
                url: actionUrl,
                data: addForm,
                contentType: false,
                processData: false,
            });
            AllScript.loader(false);
            toastr.success(response.message || 'Request successful');
            return true;
        } catch (response) {
            AllScript.loader(false);
            if (response.status === 422) {
                let errors = response.responseJSON.errors;
                $.each(errors, (field, messages) => {
                    toastr.error(messages[0]);
                });
            }else if(response.status === 402) {
                toastr.error(response.responseJSON.message); 
            }else {
                toastr.error('An error occurred. Please try again.');
            }
            return false;
        }
    },
    

    initCustomReq: function(req, actionUrl, method = 'POST'){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: method, 
            url: actionUrl,
            data: req,
            success: (response) => {                
                //  AllScript.loader(false);
                // toastr.success(response.message || 'Request successful');
                // this.navigate(response.redirectUrl || 'dashboard'); 
            },
            error: (response) => {
                //  AllScript.loader(false);
                if (response.status === 422) {
                    // Validation error occurred
                    // let errors = response.responseJSON.errors;
                    // $.each(errors, (field, messages) => {
                    //     toastr.error(messages[0]);
                    // });
                } else {
                    // console.log(response);
                    // toastr.error('An error occurred. Please try again.'); 
                }
            }
        });
    },

    deleteItem: async function(url, id = null, method = 'DELETE', msg = 'Are you sure you want to delete this record?') {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: msg,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        });
    
        if (result.isConfirmed) {
            return await this.ajaxDelete(url, id, method);
        }
        return false;
    },

    ajaxDelete: async function(url, id = null, method = 'DELETE') {
        AllScript.loader(true);
        try {
            const response = await $.ajax({
                url: url,
                type: 'POST', 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE',
                    id: id,
                },
            });
    
            toastr.success(response.message || 'Deleted successfully');
            return true;
        } catch (error) {
            console.error('Delete Error:', error);
            toastr.error(error.responseJSON?.message || 'An error occurred while deleting');
            return false;
        } finally {
            AllScript.loader(false);
        }
    },

    pagination: function(url) {
        AllScript.loader(true);
        $.ajax({
            url: url,
            type: 'GET',
            success: (response) => {
                $('#table').html(response);
                AllScript.loader(false);
            },
            error: (xhr, status, error) => {
                AllScript.loader(false);
                // toastr.error(error);
            }
        });
    },
    loadPage: function(url, id = 'table') {
        AllScript.loader(true);
        $.ajax({
            url: url,
            type: 'GET',
            success: (response) => {
                // console.log(response);
                $('#'+id).html(response);
                AllScript.initCustomScripts();
                AllScript.loader(false);
            },
            error: (xhr, status, error) => {
                AllScript.loader(false);
                toastr.error(error);
            }
        });
    },
    loadFormPage: function(url,id) {
        AllScript.loader(true);
        // $('#'+id).html(response);
        $.ajax({
            url: url,
            type: 'GET',
            success: (response) => {
                $('#'+id).html(response);
                AllScript.initCustomScripts();
                AllScript.loader(false);
            },
            error: (xhr, status, error) => {
                AllScript.loader(false);
                toastr.error(error);
            }
        });
    },
    navigate: function(url) {
        // url
    },

    confirmAlert: async function(btnTitle = 'Yes, delete it!', msg = 'Are you sure you want to delete this record?') {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: msg,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: btnTitle
        });
    
        if (result.isConfirmed) {
            return true;
        }
        return false;
    },
};


AllScript.init();
AllScript.initCustomScripts();


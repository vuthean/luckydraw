<script>
     var uploadExcelRoute = "{{ route('customer/upload-excel') }}";
     var uploadErrorRoute = "{{ route('customer/upload-error') }}";
     var deleteAllCustomer = "{{ route('customer/delete-all') }}";
     var _token = $('meta[name="csrf-token"]').attr("content");
    $("#upload-excel").change(function () {
        var file = $(this)[0].files[0];
        validateHeaderFromExcel(file, function (isValid) {
            if (isValid === false) {
                return;
            }
            processWithUpload(file);
        });


    });
    function validateHeaderFromExcel(file, callback) {
        var allowedExtensions = /(\.xlsx|\.xls)$/i;
        if (!allowedExtensions.exec(file.name)) {
            $("#file-error").text('Only Excel files with .xlsx or .xls extensions are allowed!');
            $("#file-error").removeClass('d-none').addClass('d-block');
            $('#upload-excel').val('');
            callback(false);
            return;
        }
        var reader = new FileReader();

        reader.onload = function (e) {
            var data = e.target.result;
            var workbook = XLSX.read(data, { type: 'binary' });
            var sheetName = workbook.SheetNames[0];
            var sheet = workbook.Sheets[sheetName];
            var jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

            var headers = jsonData[0];
            var originalHeaders = ['No.', 'CIF Location', 'CIF', 'Owner Name', 'Account Number', 'Phone Number','Number of Ticket'];
            
            if (arraysAreEqual(headers, originalHeaders)) {
                $("#file-error").addClass('d-none').removeClass('d-block');
                callback(true);
            } else {
                $('#myModal').modal('show');
                document.getElementById('message-error-from-api').innerHTML = 'The excel header is incorrect!';
                // $("#file-error").text('The excel header is incorrect!');
                // $("#file-error").removeClass('d-none').addClass('d-block');
                // $("#file-error").css('color','red')
                $('#upload-excel').val('');
                callback(false);
            }

        };

        reader.readAsBinaryString(file);

    }
    function arraysAreEqual(array1, array2) {
        if (array1.length !== array2.length) {
            return false;
        }

        for (var i = 0; i < array1.length; i++) {
            if (array1[i] !== array2[i]) {
                return false;
            }
        }

        return true;
    }
    function processWithUpload(file) {
        var formData = new FormData();
        var userId = $('#user_id').val();
        formData.append('upload-excel', file);
        formData.append('userId', userId);
        formData.append('_token', _token);
        $('.data-upload-table').addClass('d-none');
      
        $("#overlay").removeClass('d-none');
        $.ajax({
            url: uploadExcelRoute, // Replace with your API endpoint URL
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                $("#overlay").addClass('d-none');
                $("#file-error").addClass('d-none').removeClass('d-block');
                $('.data-upload-table').removeClass('d-none');
                $('#myModalSuccess').modal('show');
            },
            error: function (xhr, status, error) {
                var response = xhr.responseJSON; // Get the response data
                console.log(response);
                $('#myModal').modal('show');
                var invalid_rows = ''
                if(response.invalid_rows){
                    invalid_rows = response.invalid_rows
                    // const invalidRowsAsJson = JSON.parse(invalid_rows);
                    let messages = invalid_rows.map(item => `Row ${item.row}: ${item.error} : ${item.keyword}`).join('<br>');
                    document.getElementById('message-error-from-api').innerHTML = messages;
                }else{
                    document.getElementById('message-error-from-api').innerHTML = 'File uploaded unsuccessfully';
                }
                $("#overlay").addClass('d-none');
                if (response && response.code && response.message) {
                    $("#file-error").text(response.message.excel_file);
                    $("#file-error").removeClass('d-none').addClass('d-block');
                    $('#excel_file').val('');
                }

            }
        });
    }
    $('#search-file').click(function() {
        $('#error-search-file').text('');
        $('#fileList').empty();
        var formData = new FormData();
        var date = $('#date-error').val();
        formData.append('date', date);
        formData.append('_token', _token);
        $.ajax({
            url: uploadErrorRoute, // Replace with your API endpoint URL
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                const data = response.data.filename;
                const files = data[0];
                const list = document.getElementById('fileList');
                // Clear existing content
                list.innerHTML = '';

                // Loop and append each file
                files.forEach((file, index) => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.innerHTML = `
                        <div>
                        <strong>${file.filename}</strong><br>
                        <small class="text-muted">Uploaded At: ${file.date}</small>
                        </div>
                        <a download class="badge bg-primary rounded-pill" href="${file.url}">
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </a>
                    `;
                    list.appendChild(li);
                });
            },
            error: function (xhr, status, error) {
                var response = xhr.responseJSON; // Get the response data
                console.log(response);
                $('#error-search-file').text(response.message);
                $('#error-search-file').css('color', 'red');
            }
        });
    } );
    $(document).ready(function() {
        // Disable search button initially
        $('#search-file').prop('disabled', true);

        // Watch for date change
        $('#date-error').on('change keyup', function() {
            const dateVal = $(this).val();

            if (dateVal === '') {
                // Invalid or empty date
                $(this).addClass('is-invalid');
                $('#search-file').prop('disabled', true);
            } else {
                // Valid date
                $(this).removeClass('is-invalid').addClass('is-valid');
                $('#search-file').prop('disabled', false);
            }
        });
    });
    $('#btn-delete-all-customer').click(function() {
        var formData = new FormData();
        formData.append('_token', _token);
        $.ajax({
            url: deleteAllCustomer, // Replace with your API endpoint URL
            type: 'DELETE',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#modalDeleteCustomer').modal('hide');
                $('#myModalDeleteCusSuccess').modal('show');
            },
            error: function (xhr, status, error) {
                var response = xhr.responseJSON; // Get the response data
                console.log(response);
                $('#error-search-file').text(response.message);
                $('#error-search-file').css('color', 'red');
            }
        });
    });
    $('.btn-success-upload').click(function() {
        location.reload();
    });

</script>
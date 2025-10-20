<script>
    $(document).ready(function() {
        if ($.fn.select2) {
            $(".select2").select2({
                width: '100%'
            })

            $(".select2-tags").select2({
                width: '100%',
                multiple: true,
                tags: true,
            })
        }

    })

    $(document).on("input", ".numeric", function(event) {
        this.value = this.value.replace(/[^\d.]+/g, '');
    });

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    const message = (msg, msgtext, msgtype) => {
        Swal.fire(msg, msgtext, msgtype);
    }

    const messageTopRight = (type, msg) => {
        Toast.fire({
            icon: type,
            title: msg,
        });
    }

    const requestAjax = (urlRequest, dataRequet = {}, typePost, typeOutput, callbackSuccess, disabledButtonAction = "",
        textButton = "", multipartFormdata = "") => {

        const showLoading = (condition) => {
            if (disabledButtonAction !== "") {
                $(disabledButtonAction).prop("disabled", condition);
                if (condition) {
                    $(disabledButtonAction).html(
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                    );
                } else {
                    $(disabledButtonAction).html(textButton);
                }
            }
        };

        showLoading(true);

        if (typePost == "GET") {
            $.ajax({
                url: urlRequest,
                type: typePost,
                dataType: typeOutput,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    showLoading(false);
                    callbackSuccess(response)
                },
                error: function(xhr, error, status) {
                    showLoading(false);
                    messageTopRight('error', `${status} ${error}`);
                },
            });
        }

        if (typePost == "POST" || typePost == 'PUT' || typePost === "PATCH" || typePost === "DELETE") {
            if (multipartFormdata === "") {
                $.ajax({
                    url: urlRequest,
                    type: typePost,
                    data: dataRequet,
                    dataType: typeOutput,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        showLoading(false);
                        callbackSuccess(response)
                    },
                    error: function(xhr, error, status) {
                        showLoading(false);
                        messageTopRight('error', `${status} ${error}`);
                    },
                });
            }

            if (multipartFormdata === "multipart-formdata") {
                $.ajax({
                    type: typePost,
                    url: urlRequest,
                    data: dataRequet.dataForm,
                    contentType: false,
                    processData: false,
                    dataType: typeOutput,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        showLoading(false);
                        callbackSuccess(response)
                    },
                    error: function(xhr, error, status) {
                        showLoading(false);
                        messageTopRight('error', `${status} ${error}`);
                    },
                });
            }

            if (multipartFormdata !== "" && multipartFormdata !== "multipart-formdata") {
                messageTopRight('error',
                    `If you upload file, parameter the last must be <strong>multipart-formdata</strong>`);
                return false;
            }
        }
    }

    const messageBoxBeforeRequest = (textMessage, textButtonConfirm, textButtonCancel) => {
        return Swal.fire({
            title: "Are you sure?",
            text: textMessage,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: textButtonConfirm,
            cancelButtonText: textButtonCancel
        })
    }

    const setLoading = () => {
        return `<div class="spinner-border me-2" role="status"></div> Loading...`;
    }

    const validateField = (fieldData) => {
        const {
            field,
            type,
            validation,
            value
        } = fieldData;
        let errorMessage = '';

        // Validasi tambahan berdasarkan aturan validasi
        if (errorMessage === '') {
            validation.forEach(rule => {
                const ruleParts = rule.split(':');
                const ruleName = ruleParts[0];
                const ruleValue = ruleParts[1];
                switch (ruleName) {
                    case 'required':
                        if (value === '' || value === null || value === undefined || (type === 'array' &&
                                value.length === 0) || (type === 'file' && value.val() === '')) {
                            errorMessage += ', Field is required';
                        }
                        break;
                    case 'numeric':
                        if (value && isNaN(value)) {
                            errorMessage += ', Field must be numeric';
                        }
                        break;
                    case 'datetime':
                        const date = new Date(value);
                        const formattedDate =
                            `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')} ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;
                        if (typeof value === 'string' && value && !/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/
                            .test(formattedDate)) {
                            errorMessage += ', Field must be datetime';
                        }
                        break;
                    case 'max':
                        if (value && value.length > parseInt(ruleValue)) {
                            errorMessage += `, Maximum length ( ${ruleValue} character )`;
                        }
                        break;
                    case 'min':
                        if (value && value.length < parseInt(ruleValue)) {
                            errorMessage += `, Minumum length ( ${ruleValue} character )`;
                        }
                        break;
                    case 'mimes':
                        if (type === 'file' && value.val()) {
                            const allowedTypes = ruleValue.split(',');
                            const fileType = value[0].files[0].name.split('.').pop();
                            if (!allowedTypes.includes(fileType)) {
                                errorMessage +=
                                    `, Invalid file type. Allowed file types: ${ruleValue}`;
                            }
                        }
                        break;
                    case 'size':
                        if (type === 'file' && value.val()) {
                            const maxSizeInKB = parseInt(ruleValue);
                            const maxSizeInMB = maxSizeInKB / 1024;
                            const fileSizeInKB = value[0].files[0].size / 1024;
                            const fileSizeInMB = fileSizeInKB / 1024;
                            if (fileSizeInKB > maxSizeInKB) {
                                errorMessage +=
                                    `, File size must be less than ${maxSizeInMB.toFixed(2)} MB (current size: ${fileSizeInMB.toFixed(2)} MB)`;
                            }
                        }
                        break;
                    case 'alpha_dash':
                        if (value && !/^[a-zA-Z0-9-]+$/.test(value)) {
                            errorMessage +=
                                ', Field must only contain alphanumeric characters and dashes';
                        }
                        break;
                    default:
                        errorMessage += ', Invalid validation rule';
                }
            });
        }

        return errorMessage.trim().replace(/^,/, '');
    };

    const setValidation = (datas) => {
        let totalError = 0;
        datas.forEach(data => {
            const errorMessage = validateField(data);
            if (errorMessage !== '') {
                totalError++;
                $(`.error-${data.field}`).show();
                $(`.error-${data.field}`).text(errorMessage);
            } else {
                $(`.error-${data.field}`).html('');
                $(`.error-${data.field}`).hide();
            }
        });

        return totalError
    };
</script>

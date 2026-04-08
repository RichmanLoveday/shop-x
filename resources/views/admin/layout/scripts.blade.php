<script>
    // tinymce init
    // tinymce.init({
    //     selector: 'textarea#editor',
    //     height: 500,
    //     plugins: [
    //         'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
    //         'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
    //         'insertdatetime', 'media', 'table', 'help', 'wordcount',
    //         /* Premium plugins for demo purposes only */
    //         'mediaembed',
    //     ],
    //     toolbar: 'undo redo | blocks | ' +
    //         'bold italic backcolor | alignleft aligncenter ' +
    //         'alignright alignjustify | bullist numlist outdent indent | ' +
    //         'removeformat | help',
    //     content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    // });


    // SweetAlert 2
    $(function() {
        $('.delete-item').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res.status === 'error') {
                                Swal.fire(
                                    'Error!',
                                    res.message,
                                    'error'
                                );
                                return;
                            }

                            Swal.fire(
                                'Deleted!',
                                res.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            xhr = JSON.parse(xhr.responseText);
                            Swal.fire(
                                'Error!',
                                xhr.message,
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

    // Init notyf
    var notyf = new Notyf({
        duration: 3000,
    });

    CKEDITOR.disableAutoInline = true;
    CKEDITOR.config.versionCheck = false;

    CKEDITOR.replace('short-description');
    CKEDITOR.replace('long-description');

    // select 2 init
    $(document).ready(function() {
        $('.select2').select2();
    });


    // datepicker init
    $(document).ready(function() {
        if (window.Litepicker) {
            document.querySelectorAll('.datepicker').forEach(function(elem) {
                new Litepicker({
                    element: $(elem)[0],
                    minDate: new Date(),
                    buttonText: {
                        previousMonth: `<i class="ti ti-chevron-left fs-2"></i>`,
                        nextMonth: `<i class="ti ti-chevron-right fs-2"></i>`,
                    },
                });
            });
        }
    });
</script>

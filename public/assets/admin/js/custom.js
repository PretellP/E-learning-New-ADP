$(function(){

    /* ------ GENERAL ------*/

    var DataTableEs = {
        "processing": "Procesando...",
        "lengthMenu": "Mostrar _MENU_ registros",
        "zeroRecords": "No se encontraron resultados",
        "emptyTable": "Ningún dato disponible en esta tabla",
        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "search": "Buscar:",
        "infoThousands": ",",
        "loadingRecords": "Cargando...",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
            },
        "aria": {
            "sortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sortDescending": ": Activar para ordenar la columna de manera descendente"
            },
        "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad",
            "collection": "Colección",
            "colvisRestore": "Restaurar visibilidad",
            "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.",
            "copySuccess": {
            "1": "Copiada 1 fila al portapapeles",
            "_": "Copiadas %ds fila al portapapeles"
            },
        "copyTitle": "Copiar al portapapeles",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
        "-1": "Mostrar todas las filas",
        "_": "Mostrar %d filas"
        },
        "pdf": "PDF",
        "print": "Imprimir",
        "renameState": "Cambiar nombre",
        "updateState": "Actualizar",
        "createState": "Crear Estado",
        "removeAllStates": "Remover Estados",
        "removeState": "Remover",
        "savedStates": "Estados Guardados",
        "stateRestore": "Estado %d"
        },
        "autoFill": {
            "cancel": "Cancelar",
            "fill": "Rellene todas las celdas con <i>%d</i>",
            "fillHorizontal": "Rellenar celdas horizontalmente",
            "fillVertical": "Rellenar celdas verticalmentemente"
            },
        "decimal": ",",
        "searchBuilder": {
            "add": "Añadir condición",
            "button": {
            "0": "Constructor de búsqueda",
            "_": "Constructor de búsqueda (%d)"
            },
            "clearAll": "Borrar todo",
            "condition": "Condición",
            "conditions": {
        "date": {
            "after": "Despues",
            "before": "Antes",
            "between": "Entre",
            "empty": "Vacío",
            "equals": "Igual a",
            "notBetween": "No entre",
            "notEmpty": "No Vacio",
            "not": "Diferente de"
        },
        "number": {
            "between": "Entre",
            "empty": "Vacio",
            "equals": "Igual a",
            "gt": "Mayor a",
            "gte": "Mayor o igual a",
            "lt": "Menor que",
            "lte": "Menor o igual que",
            "notBetween": "No entre",
            "notEmpty": "No vacío",
            "not": "Diferente de"
        },
        "string": {
            "contains": "Contiene",
            "empty": "Vacío",
            "endsWith": "Termina en",
            "equals": "Igual a",
            "notEmpty": "No Vacio",
            "startsWith": "Empieza con",
            "not": "Diferente de",
            "notContains": "No Contiene",
            "notStartsWith": "No empieza con",
            "notEndsWith": "No termina con"
        },
        "array": {
            "not": "Diferente de",
            "equals": "Igual",
            "empty": "Vacío",
            "contains": "Contiene",
            "notEmpty": "No Vacío",
            "without": "Sin"
        }
        },
        "data": "Data",
        "deleteTitle": "Eliminar regla de filtrado",
        "leftTitle": "Criterios anulados",
        "logicAnd": "Y",
        "logicOr": "O",
        "rightTitle": "Criterios de sangría",
        "title": {
        "0": "Constructor de búsqueda",
        "_": "Constructor de búsqueda (%d)"
        },
        "value": "Valor"
        },
        "searchPanes": {
            "clearMessage": "Borrar todo",
            "collapse": {
            "0": "Paneles de búsqueda",
            "_": "Paneles de búsqueda (%d)"
            },
            "count": "{total}",
            "countFiltered": "{shown} ({total})",
            "emptyPanes": "Sin paneles de búsqueda",
            "loadMessage": "Cargando paneles de búsqueda",
            "title": "Filtros Activos - %d",
            "showMessage": "Mostrar Todo",
            "collapseMessage": "Colapsar Todo"
            },
        "select": {
            "cells": {
            "1": "1 celda seleccionada",
            "_": "%d celdas seleccionadas"
            },
            "columns": {
            "1": "1 columna seleccionada",
            "_": "%d columnas seleccionadas"
            },
            "rows": {
            "1": "1 fila seleccionada",
            "_": "%d filas seleccionadas"
            }
        },
        "thousands": ".",
        "datetime": {
            "previous": "Anterior",
            "next": "Proximo",
            "hours": "Horas",
            "minutes": "Minutos",
            "seconds": "Segundos",
            "unknown": "-",
            "amPm": [
            "AM",
            "PM"
            ],
            "months": {
            "0": "Enero",
            "1": "Febrero",
            "2": "Marzo",
            "3": "Abril",
            "4": "Mayo",
            "5": "Junio",
            "6": "Julio",
            "7": "Agosto",
            "8": "Septiembre",
            "9": "Octubre",
            "10": "Noviembre",
            "11": "Diciembre"
            },
            "weekdays": [
            "Dom",
            "Lun",
            "Mar",
            "Mie",
            "Jue",
            "Vie",
            "Sab"
            ]
        },
        "editor": {
            "close": "Cerrar",
            "create": {
            "button": "Nuevo",
            "title": "Crear Nuevo Registro",
            "submit": "Crear"
            },
            "edit": {
            "button": "Editar",
            "title": "Editar Registro",
            "submit": "Actualizar"
            },
            "remove": {
            "button": "Eliminar",
            "title": "Eliminar Registro",
            "submit": "Eliminar",
            "confirm": {
                "1": "¿Está seguro que desea eliminar 1 fila?",
                "_": "¿Está seguro que desea eliminar %d filas?"
            }
            },
            "error": {
            "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\/a&gt;).</a>"
            },
            "multi": {
            "title": "Múltiples Valores",
            "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
            "restore": "Deshacer Cambios",
            "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
            }
        },
        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "stateRestore": {
            "creationModal": {
            "button": "Crear",
            "name": "Nombre:",
            "order": "Clasificación",
            "paging": "Paginación",
            "search": "Busqueda",
            "select": "Seleccionar",
            "columns": {
                "search": "Búsqueda de Columna",
                "visible": "Visibilidad de Columna"
            },
            "title": "Crear Nuevo Estado",
            "toggleLabel": "Incluir:"
            },
            "emptyError": "El nombre no puede estar vacio",
            "removeConfirm": "¿Seguro que quiere eliminar este %s?",
            "removeError": "Error al eliminar el registro",
            "removeJoiner": "y",
            "removeSubmit": "Eliminar",
            "renameButton": "Cambiar Nombre",
            "renameLabel": "Nuevo nombre para %s",
            "duplicateError": "Ya existe un Estado con este nombre.",
            "emptyStates": "No hay Estados guardados",
            "removeTitle": "Remover Estado",
            "renameTitle": "Cambiar Nombre Estado"
        }
    };

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    const SwalDelete = Swal.mixin({
        title: '¿Estás seguro?',
        text: "¡Esta acción no podrá ser revertida!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '¡Sí!',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
    })


    /* ---- DROPDOWN BUTTON -------*/


    $('.main-content').on('click', '.btn-dropdown-container', function(){

        if (window.matchMedia('(min-width: 992px)').matches) {
            $('#btn-drowdown-category-list').removeClass('vertical')
        } else {
            $('#btn-drowdown-category-list').addClass('vertical')
        }

        var button = $(this)
        var txtCont = button.find('.text-dropdown-cont')
        var parent = button.closest('.principal-inner-container')
        var dropdownContainer = parent.find('.related-dropdown-container')
        var actionButtonContainer = parent.find('.action-btn-dropdown-container')
    
        if(button.hasClass('show')){
            txtCont.html('Mostrar')
        }else{
            txtCont.html('Ocultar')
        }

        if(button.hasClass('vertical')){
            dropdownContainer.slideToggle(300)
        }else{
            dropdownContainer.toggle('slide')
        }

        actionButtonContainer.slideToggle(300)
        button.toggleClass('show')
    })









    if($('#companies-table').length){

        var companiesTableEle = $('#companies-table');
        var getDataUrl = companiesTableEle.data('url');
        var companiesTable = companiesTableEle.DataTable({
            language: DataTableEs,
            serverSide: true,
            processing: true,
            ajax: getDataUrl,
            columns:[
                {data: 'id', name:'id'},
                {data: 'description', name:'description'},
                {data: 'abbreviation', name:'abbreviation'},
                {data: 'ruc', name:'ruc'},
                {data: 'address', name:'address'},
                {data: 'telephone', name:'telephone'},
                {data: 'status-btn', name:'status-btn'},
                {data: 'action', name:'action', orderable: false, searchable: false},
            ]
        });

        $('#register-company-status-checkbox').change(function(){
            var txtDesc = $('#txt-register-description-company');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        /* -------- REGISTRAR ---------*/

        var registerCompanyForm = $('#registerCompanyForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                ruc: {
                    required: true,
                    maxlength: 15,
                    remote: {
                        param: {
                            url: $('#registerCompanyForm').attr('action'),
                            method: $('#registerCompanyForm').attr('method'),
                            dataType: 'JSON',
                            data: {
                                ruc: function(){
                                    return $('#registerCompanyForm').find('input[name=ruc]').val()
                                },
                                type: 'validate'
                            },
                        },
                    }
                },
                abreviation: {
                    maxlength: 100
                },
                address: {
                    required: true,
                    maxlength: 255
                },
                phone: {
                    maxlength: 20
                },
                referName: {
                    maxlength: 255
                },
                referPhone: {
                    maxlength: 20
                },
                referEmail: {
                    maxlength: 50,
                    email: true
                }
            },
            messages: {
                ruc: {
                    remote: 'Este RUC ya está registrado'
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#RegisterCompanyModal')

                loadSpinner.toggleClass('active')

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: {
                        data: form.serialize(),
                        type: 'store'
                    },
                    dataType: 'JSON',
                    success: function(data){
                        registerCompanyForm.resetForm()
                        companiesTable.draw()
                        form.trigger('reset')
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registrado exitosamente!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })

        /* ---------- ELIMINAR ---------*/

        $('body').on('click', '.deleteCompany', function(){
            var url = $(this).data('url')

            SwalDelete.fire().then(function(e){
                if(e.value === true){
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'JSON',
                        success: function(result){
                            if(result.success === true){
                                companiesTable.draw();
                                Toast.fire({
                                    icon: 'success',
                                    text: '¡Registro eliminado!',
                                })
                            }
                        },
                        error: function(result){
                            Toast.fire({
                                icon: 'error',
                                title: '¡Ocurrió un error inesperado!',
                            });
                        }
                    });
                }else{
                    e.dismiss;
                }
            }, function(dismiss){
                return false;
            });
        })

        /* ------------ EDITAR --------*/

        $('#edit-company-status-checkbox').change(function(){
            var txtDesc = $('#txt-edit-description-company');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        var editCompanyform = $('#EditCompanyForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                ruc: {
                    required: true,
                    maxlength: 15,
                    remote: {
                        url: $('#EditCompanyForm').data('validate'),
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            ruc: function(){
                                return $('#EditCompanyForm').find('input[name=ruc]').val()
                            },
                            id: function(){
                                return $('#EditCompanyForm').find('input[name=id]').val()
                            }
                        },
                    }
                },
                abreviation: {
                    maxlength: 100
                },
                address: {
                    required: true,
                    maxlength: 255
                },
                phone: {
                    maxlength: 20
                },
                referName: {
                    maxlength: 255
                },
                referPhone: {
                    maxlength: 20
                },
                referEmail: {
                    maxlength: 50,
                    email: true
                }
            },
            messages: {
                ruc: {
                    remote: 'Este RUC ya está registrado'
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#EditCompanyModal')

                loadSpinner.toggleClass('active')

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function(data){
                        console.log(data)
                        companiesTable.draw()
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registro actualizado!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })

        $('body').on('click', '.editCompany', function(){
            var modal = $('#EditCompanyModal')
            var getDataUrl = $(this).data('send')
            var url = $(this).data('url')
            var form = modal.find('#EditCompanyForm')
            editCompanyform.resetForm();

            form.attr('action', url)
          
            $.ajax({
                type: 'GET',
                url: getDataUrl,
                dataType: 'JSON',
                success: function(data){

                    modal.find('input[name=id]').val(data.id);
                    modal.find('input[name=name]').val(data.description);
                    modal.find('input[name=abreviation]').val(data.abbreviation);
                    modal.find('input[name=ruc]').val(data.ruc);
                    modal.find('input[name=address]').val(data.address);
                    modal.find('input[name=phone]').val(data.telephone);
                    modal.find('input[name=referName]').val(data.name_ref);
                    modal.find('input[name=referPhone]').val(data.telephone_ref);
                    modal.find('input[name=referEmail]').val(data.email_ref);

                    if(data.active == 'S')
                    {
                        modal.find('#edit-company-status-checkbox').prop('checked', true);
                        $('#txt-edit-description-company').html('Activo');
                    }else{
                        modal.find('#edit-company-status-checkbox').prop('checked', false);
                        $('#txt-edit-description-company').html('Inactivo');
                    }
                },
                complete: function(data){
                    modal.modal('toggle')
                },
                error: function(data){
                    console.log(data)
                }
            })
        })

    }

    if($('#rooms-table').length){

        var roomsTableEle = $('#rooms-table');
        var getDataUrl = roomsTableEle.data('url');
        var roomsTable = roomsTableEle.DataTable({
            language: DataTableEs,
            serverSide: true,
            processing: true,
            ajax: getDataUrl,
            columns:[
                {data: 'id', name:'id'},
                {data: 'description', name:'description'},
                {data: 'capacity', name:'capacity'},
                {data: 'created_at', name:'created_at'},
                {data: 'status-btn', name:'status-btn'},
                {data: 'action', name:'action', orderable: false, searchable: false},
            ]
        });


        $('#register-room-status-checkbox').change(function(){
            var txtDesc = $('#txt-register-description-room');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        /* ----------- REGISTRAR -----------*/

        var registerRoomForm = $('#registerRoomForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                    remote: {
                        url: $('#registerRoomForm').data('validate'),
                        method: $('#registerRoomForm').attr('method'),
                        dataType: 'JSON',
                        data: {
                            name: function(){
                                return $('#registerRoomForm').find('input[name=name]').val()
                            }
                        }
                    }
                },
                capacity: {
                    required: true
                }
            },
            messages: {
                name: {
                    remote: 'Esta sala ya está registrada'
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#RegisterRoomModal')

                loadSpinner.toggleClass('active')

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function(data){
                        registerRoomForm.resetForm()
                        roomsTable.draw()
                        form.trigger('reset')
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registrado exitosamente!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })

        /* ---------- EDITAR ----------*/


        $('#edit-room-status-checkbox').change(function(){
            var txtDesc = $('#txt-edit-description-room');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        var editRoomForm = $('#editRoomForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                    remote: {
                        url: $('#editRoomForm').data('validate'),
                        method: $('#editRoomForm').attr('method'),
                        dataType: 'JSON',
                        data: {
                            name: function(){
                                return $('#editRoomForm').find('input[name=name]').val()
                            },
                            id: function(){
                                return $('#editRoomForm').find('input[name=id]').val()
                            }
                        }
                    }
                },
                capacity: {
                    required: true
                }
            },
            messages: {
                name: {
                    remote: 'Esta sala ya está registrada'
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#EditRoomModal')

                loadSpinner.toggleClass('active')

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function(data){
                        roomsTable.draw()
                        form.trigger('reset')
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registro actualizado!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })
        

        $('body').on('click', '.editRoom', function(){
            var modal = $('#EditRoomModal')
            var getDataUrl = $(this).data('send')
            var url = $(this).data('url')
            var form = modal.find('#editRoomForm')

            editRoomForm.resetForm();

            form.attr('action', url)
          
            $.ajax({
                type: 'GET',
                url: getDataUrl,
                dataType: 'JSON',
                success: function(data){

                    modal.find('input[name=id]').val(data.id);
                    modal.find('input[name=name]').val(data.description);
                    modal.find('input[name=capacity]').val(data.capacity);
                    modal.find('input[name=url]').val(data.url_zoom);

                    if(data.active == 'S'){
                        modal.find('#edit-room-status-checkbox').prop('checked', true);
                        $('#txt-edit-description-room').html('Activo');
                    }else{
                        modal.find('#edit-room-status-checkbox').prop('checked', false);
                        $('#txt-edit-description-room').html('Inactivo');
                    }
                },
                complete: function(data){
                    modal.modal('toggle')
                },
                error: function(data){
                    console.log(data)
                }
            })
        })


        /* ----------- ELIMINAR ---------------*/

        $('body').on('click', '.deleteRoom', function(){
            var url = $(this).data('url')

            SwalDelete.fire().then(function(e){
                if(e.value === true){
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'JSON',
                        success: function(result){
                            if(result.success === true){
                                roomsTable.draw();
                                Toast.fire({
                                    icon: 'success',
                                    text: '¡Registro eliminado!',
                                })
                            }
                        },
                        error: function(result){
                            Toast.fire({
                                icon: 'error',
                                title: '¡Ocurrió un error inesperado!',
                            });
                        }
                    });
                }else{
                    e.dismiss;
                }
            }, function(dismiss){
                return false;
            });
        })


    }

    if($('#users-table').length){

        /* -------- SELECT ----------*/

        $('#registerRoleSelect').select2({
            dropdownParent: $("#RegisterUserModal"),
            placeholder: 'Selecciona un rol'
        })

        $('#registerCompanySelect').select2({
            dropdownParent: $("#RegisterUserModal"),
            placeholder: 'Selecciona una empresa'
        })

        $('#editRoleSelect').select2({
            dropdownParent: $("#EditUserModal"),
            placeholder: 'Selecciona un rol'
        })

        $('#editCompanySelect').select2({
            dropdownParent: $("#EditUserModal"),
            placeholder: 'Selecciona una empresa'
        })


        /* --------------------------------*/

        var usersTableEle = $('#users-table');
        var getDataTable = usersTableEle.data('url');
        var usersTable = usersTableEle.DataTable({
            language: DataTableEs,
            serverSide: true,
            processing: true,
            ajax: getDataTable,
            columns:[
                {data: 'id', name:'id'},
                {data: 'dni', name:'dni'},
                {data: 'name', name:'name'},
                {data: 'email', name:'email'},
                {data: 'role', name:'role', orderable: false,},
                {data: 'company.description', name:'company.description', orderable: false},
                {data: 'status-btn', name:'status-btn', orderable: false, searchable: false},
                {data: 'action', name:'action', orderable: false, searchable: false},
            ]
        });


        $('#register-user-status-checkbox').change(function(){
            var txtDesc = $('#txt-register-description-user');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });


        /* ------------ REGISTRAR -------------*/

        var registerUserForm = $('#registerUserForm').validate({
            rules: {
                dni: {
                    required: true,
                    maxlength: 11,
                    remote: {
                        url: $('#registerUserForm').data('validate'),
                        method: $('#registerUserForm').attr('method'),
                        dataType: 'JSON',
                        data: {
                            dni: function(){
                                return $('#registerUserForm').find('input[name=dni]').val()
                            }
                        }
                    }
                },
                name: {
                    required: true,
                    maxlength: 255
                },
                paternal: {
                    required: true,
                    maxlength: 255
                },
                maternal: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    maxlength: 255,
                    email: true
                },
                password: {
                    required: true
                },
                phone: {
                    maxlength: 20
                },
                role: {
                    required: true
                },
                cip: {
                    maxlength: 10
                },
                company: {
                    required: true
                },
                position:{
                    maxlength: 255
                }
            },
            messages: {
                dni: {
                    remote: 'Este usuario ya está registrado'
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#RegisterUserModal')

                loadSpinner.toggleClass('active')

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function(data){
                        registerUserForm.resetForm()
                        usersTable.draw()
                        form.trigger('reset')
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registrado exitosamente!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })

        $('#btn-register-user-modal').on('click', function(){
            var modal = $('#RegisterUserModal')
            var button = $(this)
            var select = modal.find('#registerCompanySelect')
            var url = button.data('url')

            registerUserForm.resetForm()
            select.html('');

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'JSON',
                success: function(data){
                    var companies = data['companies']
                    select.append('<option></option>')

                    $.each(companies, function(key, values){
                        select.append('<option value="'+values.id+'">'+values.description+'</option>');
                    })
                },  
                complete: function(data){
                    modal.modal('toggle')
                },
                error: function(data){
                    console.log(data)
                }
            })

            // modal.modal('toggle')
        })


        /* -------------- EDITAR  ---------------*/

        $('#edit-user-status-checkbox').change(function(){
            var txtDesc = $('#txt-edit-description-user');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        var editUserForm = $('#editUserForm').validate({
            rules: {
                dni: {
                    required: true,
                    maxlength: 11,
                    remote: {
                        url: $('#editUserForm').data('validate'),
                        method: $('#editUserForm').attr('method'),
                        dataType: 'JSON',
                        data: {
                            dni: function(){
                                return $('#editUserForm').find('input[name=dni]').val()
                            },
                            id: function(){
                                return $('#editUserForm').find('input[name=id]').val()
                            }
                        }
                    }
                },
                name: {
                    required: true,
                    maxlength: 255
                },
                paternal: {
                    required: true,
                    maxlength: 255
                },
                maternal: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    maxlength: 255,
                    email: true
                },
                phone: {
                    maxlength: 20
                },
                role: {
                    required: true
                },
                cip: {
                    maxlength: 10
                },
                company: {
                    required: true
                },
                position:{
                    maxlength: 255
                }
            },
            messages: {
                dni: {
                    remote: 'Este usuario ya está registrado'
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#EditUserModal')

                loadSpinner.toggleClass('active')

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function(data){
                        usersTable.draw()
                        form.trigger('reset')
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registro actualizado!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })
        

        $('body').on('click', '.editUser', function(){
            var modal = $('#EditUserModal')
            var getDataUrl = $(this).data('send')
            var url = $(this).data('url')
            var form = modal.find('#editUserForm')
            var selectCompany = modal.find('#editCompanySelect')
            var selectRole = modal.find('#editRoleSelect')

            selectCompany.html('');
            editUserForm.resetForm()
            form.trigger('reset')

            form.attr('action', url)
          
            $.ajax({
                type: 'GET',
                url: getDataUrl,
                dataType: 'JSON',
                success: function(data){

                    var user = data['user'];

                    modal.find('input[name=id]').val(user.id);
                    modal.find('input[name=dni]').val(user.dni);
                    modal.find('input[name=name]').val(user.name);
                    modal.find('input[name=paternal]').val(user.paternal);
                    modal.find('input[name=maternal]').val(user.maternal);
                    modal.find('input[name=email]').val(user.email);
                    modal.find('input[name=phone]').val(user.telephone);
                    modal.find('input[name=cip]').val(user.cip);
                    modal.find('input[name=position]').val(user.position);

                    selectRole.val(user.role).change();
                    selectCompany.append('<option></option>')
                    $.each(data['companies'], function(key, values){
                        selectCompany.append('<option value="'+values.id+'">'+values.description+'</option>')
                    })

                    selectCompany.val(user.company_id).change()

                    if(user.active == 'S'){
                        modal.find('#edit-user-status-checkbox').prop('checked', true);
                        $('#txt-edit-description-user').html('Activo');
                    }else{
                        modal.find('#edit-user-status-checkbox').prop('checked', false);
                        $('#txt-edit-description-user').html('Inactivo');
                    }
                },
                complete: function(data){
                    modal.modal('toggle')
                },
                error: function(data){
                    console.log(data)
                }
            })
        })


         /* ----------- ELIMINAR ---------------*/

        $('body').on('click', '.deleteUser', function(){
            var url = $(this).data('url')

            SwalDelete.fire().then(function(e){
                if(e.value === true){
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'JSON',
                        success: function(result){
                            if(result.success === true){
                                usersTable.draw();
                                Toast.fire({
                                    icon: 'success',
                                    text: '¡Registro eliminado!',
                                })
                            }
                        },
                        error: function(result){
                            Toast.fire({
                                icon: 'error',
                                title: '¡Ocurrió un error inesperado!',
                            });
                        }
                    });
                }else{
                    e.dismiss;
                }
            }, function(dismiss){
                return false;
            });
        })


    }

    if($('#ownerCompanies-table').length){
        var ownerCompaniesTableEle = $('#ownerCompanies-table');
        var getDataUrl = ownerCompaniesTableEle.data('url');
        var ownerCompaniesTable = ownerCompaniesTableEle.DataTable({
            language: DataTableEs,
            serverSide: true,
            processing: true,
            ajax: getDataUrl,
            columns:[
                {data: 'id', name:'id'},
                {data: 'name', name:'name'},
                {data: 'created_at', name:'created_at'},
                {data: 'action', name:'action', orderable: false, searchable: false},
            ]
        });


        /* ------------ REGISTRAR -------------*/

        var registerOwnerCompanyForm = $('#registerCompanyForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50,
                    remote: {
                        url: $('#registerCompanyForm').data('validate'),
                        method: $('#registerCompanyForm').attr('method'),
                        dataType: 'JSON',
                        data: {
                            name: function(){
                                return $('#registerCompanyForm').find('input[name=name]').val()
                            }
                        }
                    }
                }
            },
            messages: {
                name: {
                    remote: 'Esta empresa titular ya está registrada'
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#RegisterCompanyModal')

                loadSpinner.toggleClass('active')

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function(data){
                        registerOwnerCompanyForm.resetForm()
                        ownerCompaniesTable.draw()
                        form.trigger('reset')
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registrado exitosamente!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })


        /* -------------- EDITAR  ---------------*/

        var editOwnerCompanyForm = $('#EditCompanyForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50,
                    remote: {
                        url: $('#EditCompanyForm').data('validate'),
                        method: $('#EditCompanyForm').attr('method'),
                        dataType: 'JSON',
                        data: {
                            name: function(){
                                return $('#EditCompanyForm').find('input[name=name]').val()
                            },
                            id: function(){
                                return $('#EditCompanyForm').find('input[name=id]').val()
                            }
                        }
                    }
                }
     
            },
            messages: {
                dni: {
                    remote: 'Esta empresa titular ya está registrada'
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#EditCompanyModal')

                loadSpinner.toggleClass('active')

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function(data){
                        editOwnerCompanyForm.resetForm()
                        ownerCompaniesTable.draw()
                        form.trigger('reset')
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registro actualizado!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })

        $('body').on('click', '.editCompany', function(){
            var modal = $('#EditCompanyModal')
            var getDataUrl = $(this).data('send')
            var url = $(this).data('url')
            var form = modal.find('#EditCompanyForm')

            editOwnerCompanyForm.resetForm()
            form.trigger('reset')

            form.attr('action', url)
          
            $.ajax({
                type: 'GET',
                url: getDataUrl,
                dataType: 'JSON',
                success: function(data){
                    modal.find('input[name=id]').val(data.id);
                    modal.find('input[name=name]').val(data.name);
                },
                complete: function(data){
                    modal.modal('toggle')
                },
                error: function(data){
                    console.log(data)
                }
            })
        })


        /* ----------- ELIMINAR ---------------*/

         $('body').on('click', '.deleteCompany', function(){
            var url = $(this).data('url')

            SwalDelete.fire().then(function(e){
                if(e.value === true){
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'JSON',
                        success: function(result){
                            if(result.success === true){
                                ownerCompaniesTable.draw();
                                Toast.fire({
                                    icon: 'success',
                                    text: '¡Registro eliminado!',
                                })
                            }
                        },
                        error: function(result){
                            Toast.fire({
                                icon: 'error',
                                title: '¡Ocurrió un error inesperado!',
                            });
                        }
                    });
                }else{
                    e.dismiss;
                }
            }, function(dismiss){
                return false;
            });
        })
    }

    if($('#courses-table').length){
        var coursesTableEle = $('#courses-table');
        var getDataUrl = coursesTableEle.data('url');
        var coursesTable = coursesTableEle.DataTable({
            language: DataTableEs,
            serverSide: true,
            processing: true,
            ajax: getDataUrl,
            columns:[
                {data: 'id', name:'id'},
                {data: 'description', name:'description', orderable: false,},
                {data: 'subtitle', name:'subtitle'},
                {data: 'date', name:'date'},
                {data: 'time_start', name:'time_start'},
                {data: 'time_end', name:'time_end'},
                {data: 'status', name:'status'},
                {data: 'action', name:'action', orderable: false, searchable: false},
            ]
        });

        /* ----------- REGISTER --------------*/

        var courseImageRegister = $('input[type="file"][name="courseImageRegister"]');
        courseImageRegister.val('');
        courseImageRegister.on("change", function(){
            var img_path = $(this)[0].value;
            var img_holder = $(this).closest('#registerCourseForm').find('.img-holder');
            var img_extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();

            if(img_extension == 'jpeg' || img_extension == 'jpg' || img_extension == 'png')
            {
                if(typeof(FileReader)!= 'undefined'){
                    img_holder.empty()
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('<img/>', {'src':e.target.result,'class':'img-fluid course_img'}).
                        appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                }else{
                    $(img_holder).html('Este navegador no soporta Lector de Archivos');
                }
            }else{
                $(img_holder).empty();
                Toast.fire({
                    icon: 'warning',
                    title: '¡Selecciona una imagen!'
                });
            }
        })

        $('#register-course-status-checkbox').change(function(){
            var txtDesc = $('#txt-register-description-course');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        var registerCourseForm = $('#registerCourseForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                subtitle: {
                    maxlength: 255
                },
                date: {
                    required: true
                },
                hours: {
                    required: true,
                    number: true,
                    step: 0.1
                },
                timeStart: {
                    required: true
                },
                timeEnd: {
                    required: true
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()

                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#RegisterCourseModal')
                var img_holder = form.find('.img-holder')

                loadSpinner.toggleClass('active')

                var formData = new FormData(form[0])

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(data){
                        registerCourseForm.resetForm()
                        coursesTable.draw()
                        loadSpinner.toggleClass('active')
                        $(img_holder).empty()
                        modal.modal('toggle')
                        form.find('input[name=name]').val('')
                        form.find('input[name=subtitle]').val('')
                        form.find('input[name=hours]').val('')

                        Toast.fire({
                            icon: 'success',
                            text: '¡Registrado exitosamente!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })


        /* -------------- EDIT  ---------------*/

        $('#edit-course-status-checkbox').change(function(){
            var txtDesc = $('#txt-edit-description-course');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        var inputCourseEdit = $('input[type="file"][name="courseImageEdit"]');
        inputCourseEdit.on("change", function(){
            var img_path = $(this)[0].value;
            var img_holder = $(this).closest('#editCourseForm').find('.img-holder');
            var currentImagePath = $(this).data('value');
            var img_extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();

            if(img_extension == 'jpeg' || img_extension == 'jpg' || img_extension == 'png')
            {
                if(typeof(FileReader)!= 'undefined'){
                    img_holder.empty()
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('<img/>', {'src':e.target.result,'class':'img-fluid course_img'}).
                        appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                }else{
                    $(img_holder).html('Este navegador no soporta Lector de Archivos');
                }
            }else{
                $(img_holder).html(currentImagePath);
                Toast.fire({
                    icon: 'warning',
                    title: '¡Selecciona una imagen!',
                });
            }

        })


        var editCourseForm = $('#editCourseForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                subtitle: {
                    maxlength: 255
                },
                date: {
                    required: true
                },
                hours: {
                    required: true,
                    number: true,
                    step: 0.1
                },
                timeStart: {
                    required: true
                },
                timeEnd: {
                    required: true
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#editCourseModal')
                var img_holder = form.find('.img-holder')

                loadSpinner.toggleClass('active')

                var formData = new FormData(form[0])

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(data){
                        editCourseForm.resetForm()
                        coursesTable.draw()
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')

                        $(img_holder).empty()

                        Toast.fire({
                            icon: 'success',
                            text: '¡Registro actualizado!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })
        
        $('body').on('click', '.editCourse', function(){
            var modal = $('#editCourseModal')
            var getDataUrl = $(this).data('send')
            var url = $(this).data('url')
            var form = modal.find('#editCourseForm')

            editCourseForm.resetForm()
            form.trigger('reset')

            form.attr('action', url)
          
            $.ajax({
                type: 'GET',
                url: getDataUrl,
                dataType: 'JSON',
                success: function(data){

                    modal.find('input[name=id]').val(data.id);
                    modal.find('input[name=name]').val(data.name);
                    modal.find('input[name=subtitle]').val(data.subtitle);
                    modal.find('input[name=date]').val(data.date);
                    modal.find('input[name=hours]').val(data.hours);
                    modal.find('input[name=timeStart]').val(data.time_start);
                    modal.find('input[name=timeEnd]').val(data.time_end);
                    modal.find('.img-holder').html('<img class="img-fluid course_img" id="image-course-edit" src="'+data.url_img+'"></img>');
                    modal.find('#image-upload-edit').attr('data-value', '<img scr="'+data.url_img+'" class="img-fluid course_img"');
                    modal.find('#image-upload-edit').val('');

                    if(data.status == 'S'){
                        modal.find('#edit-course-status-checkbox').prop('checked', true);
                        $('#txt-edit-description-course').html('Activo');
                    }else{
                        modal.find('#edit-course-status-checkbox').prop('checked', false);
                        $('#txt-edit-description-course').html('Inactivo');
                    }
                },
                complete: function(data){
                    modal.modal('toggle')
                },
                error: function(data){
                    console.log(data)
                }
            })
        })

        /* ----------- DELETE ---------------*/

        $('body').on('click', '.deleteCourse', function(){
            var url = $(this).data('url')

            SwalDelete.fire().then(function(e){
                if(e.value === true){
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'JSON',
                        success: function(result){
                            if(result.success === true){
                                coursesTable.draw();
                                Toast.fire({
                                    icon: 'success',
                                    text: '¡Registro eliminado!',
                                })
                            }
                        },
                        error: function(result){
                            Toast.fire({
                                icon: 'error',
                                title: '¡Ocurrió un error inesperado!',
                            });
                        }
                    });
                }else{
                    e.dismiss;
                }
            }, function(dismiss){
                return false;
            });
        })
        
    }

    if($('#files-folder-course-table').length){
        var filesTableEle = $('#files-folder-course-table');
        var getDataUrl = filesTableEle.data('url');
        var filesTable = filesTableEle.DataTable({
            language: DataTableEs,
            serverSide: true,
            processing: true,
            ajax: getDataUrl,
            columns:[
                {data: 'id', name:'id'},
                {data: 'name', name:'name'},
                {data: 'filename', name:'filename', orderable: false},
                {data: 'size', name:'size'},
                {data: 'parent_folder', name:'parent_folder', orderable: false},
                {data: 'created_at', name:'created_at'},
                {data: 'updated_at', name:'updated_at'},
                {data: 'action', name:'action', orderable: false, searchable: false},
            ]
        });

        $('body').on('click', '.deleteFile', function(){
            var url = $(this).data('url')

            SwalDelete.fire().then(function(e){
                if(e.value === true){
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'JSON',
                        success: function(result){
                            if(result.success === true){
                                filesTable.draw();
                                Toast.fire({
                                    icon: 'success',
                                    text: '!Archivo eliminado!',
                                })
                            }
                        },
                        error: function(result){
                            Toast.fire({
                                icon: 'error',
                                title: '¡Ocurrió un error inesperado!',
                            });
                        }
                    });
                }else{
                    e.dismiss;
                }
            }, function(dismiss){
                return false;
            });
        })

        $('#btn-destroy-folder').on('click', function(e){
            e.preventDefault()
            var form = $('#delete-folder-form')

            Swal.fire({
                title: '¿Eliminar carpeta?',
                text: "¡Esto eliminará todo el contenido de la carpeta!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '¡Sí!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
            }).then(function(e){
                if(e.value === true){
                    form.submit();
                }else{
                    e.dismiss;
                }
            }, function(dismiss){
                return false;
            });
        })
    }


    if($('#freeCourses-table').length)
    {

        /*------- CATEGORIES ----------*/

        /* ------- REGISTER ----------*/

        $('#register-category-status-checkbox').change(function(){
            var txtDesc = $('#txt-register-description-category');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        var categoryImageRegister = $('input[type="file"][name="categoryImageRegister"]');
        categoryImageRegister.val('');
        categoryImageRegister.on("change", function(){
            var img_path = $(this)[0].value;
            var img_holder = $(this).closest('#registerCategoryForm').find('.img-holder');
            var img_extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();

            if(img_extension == 'jpeg' || img_extension == 'jpg' || img_extension == 'png')
            {
                if(typeof(FileReader)!= 'undefined'){
                    img_holder.empty()
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('<img/>', {'src':e.target.result,'class':'img-fluid category_img'}).
                        appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                }else{
                    $(img_holder).html('Este navegador no soporta Lector de Archivos');
                }
            }else{
                $(img_holder).empty();
                categoryImageRegister.val('')
                Toast.fire({
                    icon: 'warning',
                    title: '¡Selecciona una imagen!'
                });
            }
        })


        var registerCategoryForm = $('#registerCategoryForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 100
                },
                categoryImageRegister: {
                    required: true
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()

                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#RegisterCategoryModal')
                var img_holder = form.find('.img-holder')
                

                loadSpinner.toggleClass('active')

                var formData = new FormData(form[0])

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(data){

                        var listContainer = $('#categories-list-container')
                        listContainer.html(data.html)

                        registerCategoryForm.resetForm()
                        loadSpinner.toggleClass('active')

                        $(img_holder).empty()
                        modal.modal('toggle')
                        form.find('input[name=name]').val('')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registrado exitosamente!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })


        /* ---------- EDIT -----------*/


        $('#edit-category-status-checkbox').change(function(){
            var txtDesc = $('#txt-edit-description-category');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        var editCategoryForm = $('#editCategoryForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 100
                }
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#editCategoryModal')
                var img_holder = form.find('.img-holder')

                loadSpinner.toggleClass('active')

                var formData = new FormData(form[0])

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(data){

                        var listContainer = $('#categories-list-container')
                        listContainer.html(data.html)

                        editCategoryForm.resetForm()
                        
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')

                        $(img_holder).empty()

                        Toast.fire({
                            icon: 'success',
                            text: '¡Registro actualizado!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })

        var inputCategoryEdit = $('input[type="file"][name="categoryImageEdit"]');
        inputCategoryEdit.on("change", function(){
            $('#editCategoryForm').validate()
            $('#image-upload-category-edit').rules('add', {required: true})

            var img_path = $(this)[0].value;
            var img_holder = $(this).closest('#editCategoryForm').find('.img-holder');
            var currentImagePath = $(this).data('value');
            var img_extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();

            if(img_extension == 'jpeg' || img_extension == 'jpg' || img_extension == 'png')
            {
                if(typeof(FileReader) != 'undefined'){
                    img_holder.empty()
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('<img/>', {'src':e.target.result,'class':'img-fluid category_img'}).
                        appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                }else{
                    $(img_holder).html('Este navegador no soporta Lector de Archivos');
                }
            }else{
                $(img_holder).html(currentImagePath);
                inputCategoryEdit.val('')
                Toast.fire({
                    icon: 'warning',
                    title: '¡Selecciona una imagen!',
                });
            }

        })



        $('.main-content').on('click', '.editCategory-btn', function(){
            var modal = $('#editCategoryModal')
            var getDataUrl = $(this).data('send')
            var url = $(this).data('url')
            var form = modal.find('#editCategoryForm')

            $('#editCategoryForm').validate()
            $('#image-upload-category-edit').rules('remove', 'required')

            editCategoryForm.resetForm()
            form.trigger('reset')

            form.attr('action', url)
          
            $.ajax({
                type: 'GET',
                url: getDataUrl,
                dataType: 'JSON',
                success: function(data){

                    modal.find('input[name=name]').val(data.description);
                    modal.find('.img-holder').html('<img class="img-fluid course_img" id="image-category-edit" src="'+data.url_img+'"></img>');
                    modal.find('#image-upload-edit').attr('data-value', '<img scr="'+data.url_img+'" class="img-fluid category_img"');
                    modal.find('#image-upload-edit').val('');

                    if(data.status == 'S'){
                        modal.find('#edit-category-status-checkbox').prop('checked', true);
                        $('#txt-edit-description-category').html('Activo');
                    }else{
                        modal.find('#edit-category-status-checkbox').prop('checked', false);
                        $('#txt-edit-description-category').html('Inactivo');
                    }
                },
                complete: function(data){
                    modal.modal('toggle')
                },
                error: function(data){
                    console.log(data)
                }
            })
        })



         /* ----------- DELETE ---------------*/

        $('.main-content').on('click', '.deleteCategory-btn', function(){
            var url = $(this).data('url')

            SwalDelete.fire().then(function(e){
                if(e.value === true){
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        dataType: 'JSON',
                        success: function(result){
                            if(result.success === true){

                                var listContainer = $('#categories-list-container')
                                listContainer.html(result.html)

                                Toast.fire({
                                    icon: 'success',
                                    text: '¡Registro eliminado!',
                                })
                            }
                        },
                        error: function(result){
                            Toast.fire({
                                icon: 'error',
                                title: '¡Ocurrió un error inesperado!',
                            });
                        }
                    });
                }else{
                    e.dismiss;
                }
            }, function(dismiss){
                return false;
            });
        })



        /* -----  FREE COURSE TABLE ----------*/


         /* -------- SELECT ----------*/

        $('#registerfreeCourseSelect').select2({
            dropdownParent: $("#RegisterfreeCourseModal"),
            placeholder: 'Selecciona una categoría'
        })


        var freeCoursesTableEle = $('#freeCourses-table');
        var getDataUrl = freeCoursesTableEle.data('url');
        var freeCoursesTable = freeCoursesTableEle.DataTable({
            language: DataTableEs,
            serverSide: true,
            processing: true,
            ajax: getDataUrl,
            columns:[
                {data: 'id', name:'id'},
                {data: 'description', name:'description'},
                {data: 'subtitle', name:'subtitle'},
                {data: 'course_category.description', name:'courseCategory.description', orderable: false},
                {data: 'sections', name:'sections', orderable: false},
                {data: 'chapters', name:'chapters', orderable: false},
                {data: 'duration', name:'duration', orderable: false},
                {data: 'active', name:'active', orderable: false, searchable: false},
                {data: 'recom', name:'recom', orderable: false, searchable: false, className: 'text-center'},
            ]
        });

        /* --------- REGISTER ----------*/

        var freeCourseImageRegister = $('input[type="file"][name="courseImageRegister"]');
        freeCourseImageRegister.val('');
        freeCourseImageRegister.on("change", function(){
            var img_path = $(this)[0].value;
            var img_holder = $(this).closest('#registerFreeCourseForm').find('.img-holder');
            var img_extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();

            if(img_extension == 'jpeg' || img_extension == 'jpg' || img_extension == 'png')
            {
                if(typeof(FileReader)!= 'undefined'){
                    img_holder.empty()
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('<img/>', {'src':e.target.result,'class':'img-fluid freecourse_img'}).
                        appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                }else{
                    $(img_holder).html('Este navegador no soporta Lector de Archivos');
                }
            }else{
                $(img_holder).empty();
                freeCourseImageRegister.val('')
                Toast.fire({
                    icon: 'warning',
                    title: '¡Selecciona una imagen!'
                });
            }
        })


        $('#register-course-status-checkbox').change(function(){
            var txtDesc = $('#txt-register-description-course');
            if(this.checked){
                txtDesc.html('Activo');
            }else{
                txtDesc.html('Inactivo')
            }
        });

        var registerFreeCourseForm = $('#registerFreeCourseForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                subtitle: {
                    maxlength: 255
                },
                category: {
                    required: true,
                },
                courseImageRegister: {
                    required: true,
                },
            },
            submitHandler: function(form, event){
                event.preventDefault()
                var form = $(form)
                var loadSpinner = form.find('.loadSpinner')
                var modal = $('#RegisterUserModal')

                loadSpinner.toggleClass('active')

                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'JSON',
                    success: function(data){
                        registerUserForm.resetForm()
                        usersTable.draw()
                        form.trigger('reset')
                        loadSpinner.toggleClass('active')
                        modal.modal('toggle')
                        Toast.fire({
                            icon: 'success',
                            text: '¡Registrado exitosamente!'
                        })
                    },
                    error: function(data){
                        console.log(data)
                    }
                })
            }
        })

        $('#btn-register-freecourse-modal').on('click', function(){
            var button = $(this)
            var modal = $('#RegisterfreeCourseModal')
            var loadSpinner = button.find('.loadSpinner')
            var url = button.data('url')
            var select = modal.find('#registerfreeCourseSelect')

            loadSpinner.toggleClass('active')
            registerFreeCourseForm.resetForm()
            select.html('')

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'JSON',
                success: function(data){
                    var categories = data['categories']
                    select.append('<option></option>')

                    $.each(categories, function(key, values){
                        select.append('<option value="'+values.id+'">'+values.description+'</option>');
                    })
                },  
                complete: function(data){
                    loadSpinner.toggleClass('active')
                    modal.modal('toggle')
                },
                error: function(data){
                    console.log(data)
                }
            })
        })

    }

 























    jQuery.extend(jQuery.validator.messages, {
        required: '<i class="fa-solid fa-circle-exclamation fa-bounce"></i> &nbsp; Este campo es obligatorio',
        email: 'Ingrese un email válido',
        number: 'Por favor, ingresa un número válido',
        step: jQuery.validator.format("Ingrese un número múltiplo de {0}"),
        maxlength: jQuery.validator.format("Ingrese menos de {0} caracteres.")
    });
})

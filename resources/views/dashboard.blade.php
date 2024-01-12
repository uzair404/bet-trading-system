<x-app-layout>
    @section('head')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <style>
            .table-wrapper {
                width: 100%;
                margin: 30px auto;
                background: #fff;
                padding: 20px;
                box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            }

            .table-title {
                padding-bottom: 10px;
                margin: 0 0 10px;
            }

            .table-title h2 {
                margin: 6px 0 0;
                font-size: 22px;
            }
            select.form-control{
                line-height: 1 !important;
                padding: 5px;
            }

            .table-title .add-new {
                float: right;
                height: 30px;
                font-weight: bold;
                font-size: 12px;
                text-shadow: none;
                min-width: 100px;
                border-radius: 50px;
                line-height: 13px;
            }

            .table-title .add-new i {
                margin-right: 4px;
            }

            table.table {
                table-layout: fixed;
            }

            table.table tr th,
            table.table tr td {
                border-color: #e9e9e9;
            }

            table.table th i {
                font-size: 13px;
                margin: 0 5px;
                cursor: pointer;
            }

            table.table th:last-child {
                width: 100px;
            }

            table.table td a {
                cursor: pointer;
                display: inline-block;
                margin: 0 5px;
                min-width: 24px;
            }

            table.table td a.add {
                color: #27C46B;
            }

            table.table td a.edit {
                color: #FFC107;
            }

            table.table td a.delete {
                color: #E34724;
            }

            table.table td i {
                font-size: 19px;
            }

            table.table td a.add i {
                font-size: 24px;
                margin-right: -1px;
                position: relative;
                top: 3px;
            }

            table.table .form-control {
                height: 32px;
                line-height: 32px;
                box-shadow: none;
                border-radius: 2px;
            }

            table.table .form-control.error {
                border-color: #f50000;
            }

            table.table td .add {
                display: none;
            }
        </style>
        <script>
            $(document).ready(function() {
                
                var actions = `<a class="add" ><i class="material-icons">&#xE03B;</i></a>
                                    <a class="delete"><i class="material-icons">&#xE872;</i></a>`;
                // Append table with add row form on add new button click
                $(".add-new").click(function() {
                    $(this).attr("disabled", "disabled");
                    var index = $("table tbody tr:last-child").index();
                    var row = '<tr>' +
                        '<td><input type="date" class="form-control" name="date" id="date"></td>' +
                        '<td><input type="text" class="form-control" name="league" id="league"></td>' +
                        '<td><input type="text" class="form-control" name="Bet" id="bet"></td>' +
                        '<td><select class="form-control" name="type" id="type"><option value="Straight">Straight</option><option value="Parlay">Parlay</option></select></td>' +
                        '<td><select class="form-control" name="outcome" id="outcome"><option value="Win">Win</option><option value="Loss">Loss</option></select></td>' +
                        '<td><input type="number" class="form-control" step="any" name="risk" id="risk"></td>' +
                        '<td><input type="number" class="form-control" step="any" name="reward" id="reward"></td>' +
                        '<td><span id="profit">...</span></td>' +
                        '<td>' + actions + '</td>' +
                        '</tr>';
                    $("table").append(row);
                    $("table tbody tr").eq(index + 1).find(".add").show();
                    
                });
                // Add row on add button click
                $(document).on("click", ".add", function() {
                    var empty = false;
                    var input = $(this).parents("tr").find('input,select');
                    input.each(function() {
                        if (!$(this).val()) {
                            $(this).addClass("error");
                            empty = true;
                        } else {
                            $(this).removeClass("error");
                        }
                    });
                    $(this).parents("tr").find(".error").first().focus();
                    parent = $(this).parents("tr");
                    if (!empty) {
                        // Ajax request to add a new bet
                        $(".add").attr("disabled", "disabled");
                        $.ajax({
                            url: '/bet/add',
                            type: 'POST',
                            data: {
                                '_token' : '{{csrf_token()}}',
                                date: $('#date').val(),
                                league: $('#league').val(),
                                bet: $('#bet').val(),
                                type: $('#type').val(),
                                outcome: $('#outcome').val(),
                                risk: $('#risk').val(),
                                reward: $('#reward').val(),
                            },
                            
                            success: function (response) {
                                alertify.success(response.message);
                                $("#profit").html(response.profit);
                                // update the table as needed
                                input.each(function() {
                                    $(this).parent("td").html($(this).val());
                                });
                                parent.attr('data-id', response.bet_id)
                                $(".add").hide();
                                $(".add-new").removeAttr("disabled");
                                $(".add").removeAttr("disabled");
                            },
                            error: function (error) {
                                console.error(error);
                                alertify.error('Error adding bet, '+error.responseJSON.message);
                                $(".add").removeAttr("disabled");
                            }
                        });
                        
                    }                    
                });
                // Edit row on edit button click
                // $(document).on("click", ".edit", function() {
                //     $(this).parents("tr").find("td:not(:last-child)").each(function() {
                //         $(this).html('<input type="text" class="form-control" value="' + $(this)
                //         .text() + '">');
                //     });
                //     $(this).parents("tr").find(".add, .edit").toggle();
                //     $(".add-new").attr("disabled", "disabled");
                // });
                
                // Delete row on delete button click
                $(document).on("click", ".delete", function() {
                    var betId = $(this).closest('tr').attr('data-id');
                    parent = $(this).parents("tr");
                    if (betId==undefined) {
                        parent.remove();
                        $(".add-new").removeAttr("disabled");
                        return
                    }
                    // Ajax request to delete a bet
                    $.ajax({
                        url: '/bet/delete/' + betId,
                        type: 'DELETE',
                        data: {'_token' : '{{csrf_token()}}'},
                        success: function (response) {
                            // update the table as needed
                            alertify.success(response.message);
                            parent.remove();
                            $(".add-new").removeAttr("disabled");
                        },
                        error: function (error) {
                            console.error(error);
                            alertify.error('Error deleting bet, '+error.responseJSON.message);
                        }
                    });
                });
            });
        </script>
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8"><h2>Your <b>Bet Details</b></h2></div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>League</th>
                                <th>Bet</th>
                                <th>Type</th>
                                <th>Outcome</th>
                                <th>Risk</th>
                                <th>Reward</th>
                                <th>Profit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <td colspan="9" style="text-align:center;" id="no-data-err">No Data Found</td>
                            </tr> --}}
                            @foreach ($bets as $bet)
                                <tr data-id="{{$bet->id}}">
                                    <td>{{$bet->date}}</td>
                                    <td>{{$bet->bet}}</td>
                                    <td>{{$bet->league}}</td>
                                    <td>{{$bet->type}}</td>
                                    <td>{{$bet->outcome}}</td>
                                    <td>{{$bet->risk}}</td>
                                    <td>{{$bet->reward}}</td>
                                    <td>{{$bet->profit}}</td>
                                    <td>
                                        <a class="add"><i class="material-icons">&#xE03B;</i></a>
                                        <a class="delete"><i class="material-icons">&#xE872;</i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

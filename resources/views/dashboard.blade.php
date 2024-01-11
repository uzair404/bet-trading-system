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
        {{-- Date: MM-DD-YYY (format)
                League: (user text input)
                Bet: (user text input)
                Type: "Straight" or "Parlay" (user select option)
                Outcome: "Win" or "Loss" (user select option)
                Risk: float (user input float)
                Reward: float (user input float)
                Profit: if (Outcome == "Loss"), then ( = -Risk); else (Reward - Risk) --}}
        <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
                var actions = $("table td:last-child").html();
                // Append table with add row form on add new button click
                $(".add-new").click(function() {
                    $(this).attr("disabled", "disabled");
                    var index = $("table tbody tr:last-child").index();
                    var row = '<tr>' +
                        '<td><input type="date" class="form-control" name="date" id="date"></td>' +
                        '<td><input type="text" class="form-control" name="league" id="league"></td>' +
                        '<td><input type="text" class="form-control" name="Bet" id="Bet"></td>' +
                        '<td><select class="form-control" name="type" id="type"><option value="Straight">Straight</option><option value="Parlay">Parlay</option></select></td>' +
                        '<td><select class="form-control" name="outcome" id="outcome"><option value="Win">Win</option><option value="Loss">Loss</option></select></td>' +
                        '<td><input type="number" class="form-control" step="any" name="risk" id="risk"></td>' +
                        '<td><input type="number" class="form-control" step="any" name="reward" id="reward"></td>' +
                        '<td id="profit"></td>' +
                        '<td>' + actions + '</td>' +
                        '</tr>';
                    $("table").append(row);
                    $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
                    $('[data-toggle="tooltip"]').tooltip();
                });
                // Add row on add button click
                $(document).on("click", ".add", function() {
                    //set profit
                    let Outcome = $('#outcome').val();
                    let Risk = $('#risk').val();
                    let Reward = $('#reward').val();
                    if (Outcome == "Loss"){
                        profit = -Risk;
                    } else {
                        profit = Reward - Risk;
                    }
                    $("#profit").html(profit);



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
                    if (!empty) {
                        input.each(function() {
                            $(this).parent("td").html($(this).val());
                        });
                        $(this).parents("tr").find(".add, .edit").toggle();
                        $(".add-new").removeAttr("disabled");
                    }
                });
                // Edit row on edit button click
                $(document).on("click", ".edit", function() {
                    $(this).parents("tr").find("td:not(:last-child)").each(function() {
                        $(this).html('<input type="text" class="form-control" value="' + $(this)
                        .text() + '">');
                    });
                    $(this).parents("tr").find(".add, .edit").toggle();
                    $(".add-new").attr("disabled", "disabled");
                });
                // Delete row on delete button click
                $(document).on("click", ".delete", function() {
                    $(this).parents("tr").remove();
                    $(".add-new").removeAttr("disabled");
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
                {{-- <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div> --}}
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>22-10-2024</td>
                                <td>Test</td>
                                <td>Bet</td>
                                <td>Parlay</td>
                                <td>Win</td>
                                <td>10</td>
                                <td>5.1</td>
                                <td>4.9</td>
                                <td>
                                    <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                    <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                    <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

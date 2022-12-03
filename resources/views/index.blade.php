<!doctype html>
<html lang="pt-BR">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-size: 14px; 
        }

        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

    <title>Portaria</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script> 
        $(document).ready(function() {
            
            /** 
             * MASCARAS
             */
            $('input[id=cpf]').mask('000.000.000-00'); 
            $('input[id=cadCpf]').mask('000.000.000-00'); 

            $("body").on("click", function(){
                $('input[id=cadCpf]').mask('000.000.000-00'); 
            });

            /**
             * LISTAGEM 
             */
            $.ajax({
                url: "http://localhost:8000/list-checkin",
                crossDomain: true, 
                dataType: 'json',
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    var html = "";
                    $.each(data, function(index, value) {
                            html += "<tr>";
                            html += "<td>"+value.name+"</td>";
                            html += "<td>"+value.entrada+"</td>";
                            html += "<td style='text-align: center;'>";
                            html += "<a href='javascript:;' class='remover' data-key='"+value.id+"'>";
                            html += "<svg style='cursor:pointer' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-right-circle' viewBox='0 0 16 16'>";
                            html += "<path fill-rule='evenodd' d='M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.854 10.803a.5.5 0 1 1-.708-.707L9.243 6H6.475a.5.5 0 1 1 0-1h3.975a.5.5 0 0 1 .5.5v3.975a.5.5 0 1 1-1 0V6.707l-4.096 4.096z'/>";
                            html += "</svg>";
                            html += "</td>";
                            html += "</tr>";
                    }); 

                    $("#list").html(html);
                },
                error: function (data) {
                        
                }
            });
            
            /**
             * REMOVER DA LISTA
             */
            $("body").on('click', ".remover", function() {

                var deliveryman = $(this).data('key');
                 console.log(deliveryman);
                $.ajax({
                    url: "http://localhost:8000/remover",
                    crossDomain: true, 
                    dataType: 'json',
                    data: {
                        deliveryman:deliveryman, 
                    },  
                    type: 'POST',
                    success: function(data) {
                        if(data.status == "success") {
                            location.reload(true);
                        }
                    },
                    error: function (data) {
                        console.log(data); 
                    }
                });
            }); 

            /** 
             * REGISTRAR NA LISTA
             */
            $("body").on('click', ".registrar", function() {

                var deliveryman = $(this).data('key');
                var empresa = $("#cadEmpresa").val();

                $.ajax({
                    url: "http://localhost:8000/registrar",
                    crossDomain: true, 
                    dataType: 'json',
                    data: {
                        deliveryman:deliveryman, 
                        empresa:empresa
                    },  
                    type: 'POST',
                    success: function(data) {
                        if(data.status == "success") {
                            location.reload(true);
                        }
                    },
                    error: function (data) {
                        console.log(data); 
                    }
                });
            }); 

            /**
             * NOVO ENTREGADOR
             */
            $("body").on('click', "#cadastrar", function() {
                var cpf = $("#cadCpf").val();
                var name = $("#cadNome").val();
                var empresa = $("#cadEmpresa").val(); 

                $.ajax({
                    url: "http://localhost:8000/deliveryman",
                    crossDomain: true, 
                    dataType: 'json',
                    data: {
                        name:name,
                        cpf:cpf,
                        empresa:empresa
                    },  
                    type: 'POST',
                    success: function(data) {
                        if(data.status == "success") {
                            location.reload(true);
                        }
                    },
                    error: function (data) {
                        console.log(data); 
                    }
                });
            }); 

            /**
             * BUSCAR POR CPF
             */
            $('#buscar').click(function(){
                var cpf = $("#cpf").val(); 
                $("#dados").val('');

                if(cpf.length == 14) { 
                    $.ajax({
                        url: "http://localhost:8000/busca-cpf/" + cpf,
                        crossDomain: true, 
                        dataType: 'json',
                        type: 'GET',
                        success: function(data) {

                            var cpf = data.cpf;  
                            if (cpf != "") {
                                
                                var html  = "<div class='card' style='width: 100%; min-height:200px; margin-top: 20px;'>";
                                    html += "<div class='card-body'>";
                                    html += "<p class='card-title' style='color:green'>Entregador Encontrado!</p>";
                                    html += "<p class='card-text' style='margin-top:20px; padding:0px'>";
                                    html += "<span style='font-weight: bold;'>CPF: </span>" + data.cpf ;
                                    html += "</p>";
                                    html += "<p class='card-text' style='margin-top:-15px; padding:0px'>";
                                    html += "<span style='font-weight: bold;'>Nome: </span>" + data.name;
                                    html += "</p>";
                                    html += "<p class='card-text' style='margin-top:0px; padding:0px'><span style='font-weight: bold;'>Nome da empresa</span></p>";
                                    html += "<input type='text' style='margin-top:-15px; margin-bottom:15px; padding:10px' id='cadEmpresa' class='form-control'>";
                                    html += "<a href='#' class='card-link registrar' data-key='"+data.id+"'>Registrar Entrada</a>"; 
                                    html += "</div>";
                                    html += "</div>";
                            }  

                            $("#dados").html(html);
                        },
                        error: function (data) {
                            $("#cpf").val('');

                            var html  = "<div class='card' style='width: 100%; margin-top: 20px;'>";
                                html += "<div class='card-body'>";
                                html += "<h5 class='card-title' style='color:red'>Nenhum Entregador Encontrado!</h5>";
                                html += "<h6 class='card-subtitle mb-2 text-muted'>Preencha o formulário para cadastrar</h6>";
                                
                                html += "<p class='card-text' style='margin-top:20px; padding:0px'>";
                                html += "   <span style='font-weight: bold;'>CPF: </span>";
                                html += "   <input style='padding:10px' type='text' id='cadCpf' value='"+cpf+"' class='form-control'>";
                                html += "</p>";

                                html += "<p class='card-text' style='margin-top:-10px; padding:0px'>";
                                html += "   <span style='font-weight: bold;'>Nome: </span>";
                                html += "   <input style='padding:10px' type='text' id='cadNome' class='form-control'>";
                                html += "</p>"; 

                                html += "<p class='card-text' style='margin-top:-10px; padding:0px'>";
                                html += "   <span style='font-weight: bold;'>Nome da empresa: </span>";
                                html += "   <input style='padding:10px' type='text' id='cadEmpresa' class='form-control'>";
                                html += "</p>"; 

                                html += "<a href='javascript:;' class='card-link' id='cadastrar'>Cadastrar e Registrar Entrada</a>"; 
                                html += "</div>";
                                html += "</div>";

                            $("#dados").html(html);
                        }
                    });
                } else {
                    var html  = "<div class='card' style='width: 100%; margin-top: 20px; background-color:#ff000c26'>";
                        html += "<div class='card-body' style='text-align: center; '>";
                        html += "<h5 class='card-title' style='color:red; margin-top:10px'>CPF Inválido</h5>"; 
                        html += "</div>";
                        html += "</div>";

                    $("#dados").html(html);
                }
            }); 
        });
    </script>    
</head>

<body>
    <div class="container">
        <div style="margin-top: 20px;">
            <div class="row" style="margin-bottom: 20px">
                <div class="col-2"></div>
                <div class="col-8">
                    <h2 class="text-center" style="font-size:40px">Portaria</h2>
                    <p class="text-center" style="font-size:24px; margin-top: -20px;">Dez Covanca</p>
                </div>
                <div class="col-2"></div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="input-group mb-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">CPF</span>
                        </div> 
                        <input id="cpf" type="text" class="form-control" placeholder="Apenas números" aria-label="Username" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <button id="buscar" type="button" class="btn btn-danger">Buscar</button>
                        </div> 
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-3">
                    <div id="dados"></div>                     
                </div>
                <div class="col-5">
                    <div class='card' style='width: 100%; margin-top: 20px;'> 
                        <div class='card-body'> 
                            <p class='card-title'>Relatório</p> 
                            <h6 class='card-subtitle mb-2 text-muted'>Entregadores com checkin realizado!</h6> 
                            <table class="table">
                                <thead>
                                    <tr style="font-size: 14px">
                                        <th scope="col" style="width: 40%;">Nome</th> 
                                        <th scope="col" style="width: 40%;">Entrada</th> 
                                        <th scope="col">Remover</th>
                                    </tr>
                                </thead>
                                <tbody id="list"></tbody>
                            </table> 
                        </div> 
                    </div> 
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </div>    
</body>
</html>


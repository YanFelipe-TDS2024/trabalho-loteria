<?php

function printarNomes(...$Nomes){
    foreach ($Nomes as $i => $Nome){
        print("[" . $i + 1 . "] " . $Nome . "\n");
    }

    return readline("");
}

function pegarQuantidadeNumeros($MinimoNumeros, $MaximoNumeros, &$Contador){
    $QuantidadeNumeros = 0;

    while(true){
        system("clear");

        if($Contador == 0){
            print("Quantas dezenas deseja gerar para todas as apostas?\n\n");
        }else{
            print("Quantas dezenas deseja gerar para Aposta n°" . $Contador . "?\n\n");
        }
    
        print("Mínimo: " . $MinimoNumeros . "\n");
        print("Máximo: " . $MaximoNumeros . "\n");
    
        $QuantidadeNumeros = readline("");
    
        if($QuantidadeNumeros >= $MinimoNumeros & $QuantidadeNumeros <= $MaximoNumeros){
            $Contador++;
            break;
        }else{
            system("clear");

            print("Número fora do intervalo apresentado!\n\n");
            readline("[PRESSIONE ENTER PARA TENTAR NOVAMENTE]");
        }
    }

    return $QuantidadeNumeros;
}

function gerarApostas($ComecoCartela, $FinalCartela, $MinimoNumeros, $MaximoNumeros, $Loteria, $PRECOS_APOSTAS){
    $NumeroApostas = readline("Quantas apostas deseja gerar? Digite 0 para cancelar. ");

    if ($NumeroApostas <= 0) { return; }

    $ValorTotal = 0.00;
    $TodasApostas = [];
    $Contador = 0;
    $QuantidadeNumeros = 0;

    if($NumeroApostas > 1 & $MinimoNumeros != $MaximoNumeros){
        while(true){
            system("clear");
    
            print("Deseja gerar todas as apostas com a mesma quantidade de dezenas?\n\n");
            print("[1] Sim, gerar todas com a mesma quantidade de dezenas.\n");
            print("[2] Não, desejo escolher a quantidade de dezenas em cada aposta.\n");
    
            $Escolha = readline("");
    
            if($Escolha == 1){
                $QuantidadeNumeros = pegarQuantidadeNumeros($MinimoNumeros, $MaximoNumeros, $Contador);
                $Contador = 0;
    
                break;
            }elseif($Escolha == 2){
                $Contador = 1;
                break;
            }
        }
    }elseif($MinimoNumeros != $MaximoNumeros){
        $Contador = 1;
    }else{
        $QuantidadeNumeros = $MaximoNumeros;
    }

    for ($i=$NumeroApostas; $i > 0; $i--) {
        $Aposta = [];

        if($Contador > 0){
            $QuantidadeNumeros = pegarQuantidadeNumeros($MinimoNumeros, $MaximoNumeros, $Contador);
        }
    
        for ($j=1; $j <= $QuantidadeNumeros; $j++) {
            while(true){
                $Gerado = rand($ComecoCartela, $FinalCartela);

                if(!in_array($Gerado, $Aposta)){
                    array_push($Aposta, $Gerado);
                    break;
                }
            }
        }

        asort($Aposta);

        $ValorTotal += $PRECOS_APOSTAS[$Loteria][$QuantidadeNumeros - $MinimoNumeros];

        array_push($TodasApostas, $Aposta);
    }

    system("clear");

    if($NumeroApostas == 1){
        print("Aqui está a sua aposta!\n");
    }else{
        print("Aqui estão as suas apostas!\n");
    }
    
    foreach($TodasApostas as $Aposta){
        print("\n");
        $Numeros = 0;

        foreach($Aposta as $Numero){
            print($Numero . " ");
            $Numeros++;
        }
        print("(R$" . number_format($PRECOS_APOSTAS[$Loteria][$Numeros - $MinimoNumeros],2,",",".") . ")");
    }

    print("\n\nVALOR TOTAL: R$" . number_format($ValorTotal,2,",",".") . "\n\n");

    readline("[PRESSIONE ENTER PARA CONTINUAR]");
}

function selecionarLoteria(){
    $PRECOS_APOSTAS = [
        "Mega-Sena" => [
            5.00,
            35.00,
            140.00,
            420.00,
            1050.00,
            2310.00,
            4620.00,
            8580.00,
            15015.00,
            25025.00,
            40040.00,
            61880.00,
            92820.00,
            135660.00,
            193800.00
        ],

        "Quina" => [
            2.50,
            15.00,
            52.50,
            140.00,
            315.00,
            630.00,
            1150.00,
            1980.00,
            3217.50,
            5005.00,
            7507.50
        ],

        "Lotomania" => [
            3.00
        ],

        "Lotofácil" => [
            3.00,
            48.00,
            408.00,
            2448.00,
            11628.00,
            46512.00
        ]
    ];    

    while (true){
        system("clear");

        print("Escolha o jogo que deseja gerar as dezenas!\n\n");
        $Escolhido = printarNomes("Mega-Sena", "Quina", "Lotomania", "Lotofácil", "Finalizar");
    
        system("clear");
    
        if($Escolhido == 1){
            gerarApostas(1, 60, 6, 20, "Mega-Sena", $PRECOS_APOSTAS);
        }elseif($Escolhido == 2){
            gerarApostas(1, 80, 5, 15, "Quina", $PRECOS_APOSTAS);
        }elseif($Escolhido == 3){
            gerarApostas(0, 99, 50, 50, "Lotomania", $PRECOS_APOSTAS);
        }elseif($Escolhido == 4){
            gerarApostas(1, 25, 15, 20, "Lotofácil", $PRECOS_APOSTAS);
        }elseif($Escolhido == 5){
            break;
        }
    }
}
selecionarLoteria();

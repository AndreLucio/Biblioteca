<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 2019-03-16
 * Time: 14:57
 */

    class Reserva {
        private $id_reserva;
        private $idtb_usuaio;
        private $dataReserva;
        private $dataVencimento;
        private $observacao;
        private $status;

        public function __construct($id_reserva, $idtd_usuaio, $dataReserva, $dataVencimento, $observacao, $status) {
            $this->id_reserva = $id_reserva;
            $this->idtb_usuaio = $id_usuario;
            $this->dataReserva = $dataReserva;
            $this->dataVencimento = $dataVencimento;
            $this->observacao = $observacao;
            $this->status = $status;
        }
        public function getIdReserva() {
            return $this->id_reserva;
        }
    
        public function setIdReserva($id_reserva) {
            $this->id_reserva = $id_reserva;
        }
        public function getIdUsuario() {
            return $this->id_usuario;
        }
    
        public function setIdUsuario($idtb_usuaio) {
            $this->idtb_usuaio = $idtb_usuaio;
        }
    
        public function getDataReserva() {
            return $this->dataReserva;
        }
    
        public function setDataReserva($dataReserva) {
            $this->dataReserva = $dataReserva;
        }
        public function getDataVencimento() {
            return $this->dataVencimento;
        }
    
        public function setDataVencimento($dataVencimento) {
            $this->dataVencimento = $dataVencimento;
        }
        public function getObservacao() {
            return $this->observacao;
        }
    
        public function setObservacao($observacao) {
            $this->observacao = $observacao;
        }
        public function getStatus() {
            return $this->status;
        }
    
        public function setStatus($status) {
            $this->status = $status;
        }
    }
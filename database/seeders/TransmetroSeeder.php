<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Municipalidad;
use App\Models\Linea;
use App\Models\Estacion;
use App\Models\Acceso;
use App\Models\Guardia;
use App\Models\Parqueo;
use App\Models\Bus;
use App\Models\Piloto;
use App\Models\HistorialEducativo;
use App\Models\Operador;
use App\Models\Alerta;
use App\Models\RegistroEspera;

class TransmetroSeeder extends Seeder
{
    public function run(): void
    {
        $guatemala  = Municipalidad::create(['nombre' => 'Ciudad de Guatemala', 'departamento' => 'Guatemala', 'telefono' => '2285-9800']);
        $mixco      = Municipalidad::create(['nombre' => 'Mixco', 'departamento' => 'Guatemala', 'telefono' => '2442-3100']);
        $villaNueva = Municipalidad::create(['nombre' => 'Villa Nueva', 'departamento' => 'Guatemala', 'telefono' => '6630-9900']);

        $est = [];
        $estData = [
            ['nombre' => 'Estacion Central',         'municipalidad_id' => $guatemala->id,  'capacidad_maxima' => 1000, 'ocupacion_actual' => 250],
            ['nombre' => 'Estacion Los Proceres',    'municipalidad_id' => $guatemala->id,  'capacidad_maxima' => 800,  'ocupacion_actual' => 420],
            ['nombre' => 'Estacion Trebol',          'municipalidad_id' => $guatemala->id,  'capacidad_maxima' => 900,  'ocupacion_actual' => 500],
            ['nombre' => 'Estacion Roosevelt',       'municipalidad_id' => $guatemala->id,  'capacidad_maxima' => 700,  'ocupacion_actual' => 180],
            ['nombre' => 'Estacion Centra Norte',    'municipalidad_id' => $guatemala->id,  'capacidad_maxima' => 1200, 'ocupacion_actual' => 640],
            ['nombre' => 'Estacion Plaza Berlin',    'municipalidad_id' => $mixco->id,      'capacidad_maxima' => 600,  'ocupacion_actual' => 120],
            ['nombre' => 'Estacion Mixco Caminero',  'municipalidad_id' => $mixco->id,      'capacidad_maxima' => 750,  'ocupacion_actual' => 310],
            ['nombre' => 'Estacion Villa Nueva',     'municipalidad_id' => $villaNueva->id, 'capacidad_maxima' => 800,  'ocupacion_actual' => 200],
            ['nombre' => 'Estacion Petapa',          'municipalidad_id' => $villaNueva->id, 'capacidad_maxima' => 650,  'ocupacion_actual' => 330],
            ['nombre' => 'Estacion Zona 1 Terminal', 'municipalidad_id' => $guatemala->id,  'capacidad_maxima' => 1100, 'ocupacion_actual' => 580],
            ['nombre' => 'Estacion Aguilar Batres',  'municipalidad_id' => $guatemala->id,  'capacidad_maxima' => 750,  'ocupacion_actual' => 90],
            ['nombre' => 'Estacion Eje Sur Norte',   'municipalidad_id' => $guatemala->id,  'capacidad_maxima' => 900,  'ocupacion_actual' => 460],
        ];
        foreach ($estData as $e) { $est[] = Estacion::create($e); }

        $accesosDatos = [
            [0, 'Acceso Norte - Av. Reforma',         'Carlos Aju Boj',       '5512-3456'],
            [0, 'Acceso Sur - Calle 7',               'Maria Xol Cac',        '5623-7890'],
            [1, 'Acceso Principal - Blvd. Proceres',  'Jose Choc Toj',        '5734-1234'],
            [2, 'Acceso Trebol Norte',                'Ana Cux Sic',          '5845-5678'],
            [2, 'Acceso Trebol Sur',                  'Pedro Batz Aju',       '5956-9012'],
            [3, 'Acceso Roosevelt Este',              'Luis Yat Chub',        '5067-3456'],
            [4, 'Acceso Centra Norte Principal',      'Rosa Tzoc Bal',        '5178-7890'],
            [4, 'Acceso Centra Norte Secundario',     'Diego Caal Xol',       '5289-1234'],
            [5, 'Acceso Plaza Berlin',                'Carmen Choc Aj',       '5390-5678'],
            [6, 'Acceso Mixco Principal',             'Fernando Toj Batz',    '5401-9012'],
            [7, 'Acceso Villa Nueva Norte',           'Gloria Sic Cux',       '5512-3456'],
            [8, 'Acceso Petapa Sur',                  'Roberto Bal Tzoc',     '5623-7890'],
            [9, 'Acceso Zona 1 A',                   'Elena Xol Choc',       '5734-1234'],
            [9, 'Acceso Zona 1 B',                   'Miguel Cac Toj',       '5845-5678'],
            [10,'Acceso Aguilar Batres',              'Silvia Aju Boj',       '5956-9012'],
            [11,'Acceso Eje Sur',                     'Marcos Chub Yat',      '5067-3456'],
        ];
        foreach ($accesosDatos as [$idx, $desc, $gnom, $gtel]) {
            $acc = Acceso::create(['estacion_id' => $est[$idx]->id, 'descripcion' => $desc]);
            Guardia::create(['acceso_id' => $acc->id, 'nombre' => $gnom, 'telefono' => $gtel]);
        }

        $parqueos = [
            Parqueo::create(['estacion_id' => $est[0]->id,  'nombre' => 'Parqueo Central Norte', 'capacidad' => 30]),
            Parqueo::create(['estacion_id' => $est[2]->id,  'nombre' => 'Parqueo Trebol',         'capacidad' => 25]),
            Parqueo::create(['estacion_id' => $est[4]->id,  'nombre' => 'Parqueo Centra Norte',   'capacidad' => 35]),
            Parqueo::create(['estacion_id' => $est[6]->id,  'nombre' => 'Parqueo Mixco',          'capacidad' => 20]),
            Parqueo::create(['estacion_id' => $est[7]->id,  'nombre' => 'Parqueo Villa Nueva',    'capacidad' => 20]),
            Parqueo::create(['estacion_id' => $est[9]->id,  'nombre' => 'Parqueo Zona 1',         'capacidad' => 40]),
        ];

        $linea12    = Linea::create(['municipalidad_id' => $guatemala->id,  'nombre' => 'Linea 12',    'distancia_total' => 18.5, 'cantidad_buses' => 0]);
        $ejeSur     = Linea::create(['municipalidad_id' => $guatemala->id,  'nombre' => 'Eje Sur',     'distancia_total' => 22.3, 'cantidad_buses' => 0]);
        $lineaNorte = Linea::create(['municipalidad_id' => $mixco->id,      'nombre' => 'Linea Norte', 'distancia_total' => 15.7, 'cantidad_buses' => 0]);
        $lineaCentro= Linea::create(['municipalidad_id' => $villaNueva->id, 'nombre' => 'Linea Centro','distancia_total' => 12.4, 'cantidad_buses' => 0]);

        $linea12->estaciones()->attach([
            $est[0]->id => ['orden' => 1, 'distancia' => 0],
            $est[1]->id => ['orden' => 2, 'distancia' => 4.2],
            $est[2]->id => ['orden' => 3, 'distancia' => 3.8],
            $est[3]->id => ['orden' => 4, 'distancia' => 5.1],
            $est[9]->id => ['orden' => 5, 'distancia' => 5.4],
        ]);
        $ejeSur->estaciones()->attach([
            $est[4]->id  => ['orden' => 1, 'distancia' => 0],
            $est[10]->id => ['orden' => 2, 'distancia' => 6.5],
            $est[11]->id => ['orden' => 3, 'distancia' => 7.2],
            $est[7]->id  => ['orden' => 4, 'distancia' => 8.6],
        ]);
        $lineaNorte->estaciones()->attach([
            $est[5]->id => ['orden' => 1, 'distancia' => 0],
            $est[6]->id => ['orden' => 2, 'distancia' => 5.3],
            $est[0]->id => ['orden' => 3, 'distancia' => 10.4],
        ]);
        $lineaCentro->estaciones()->attach([
            $est[8]->id => ['orden' => 1, 'distancia' => 0],
            $est[7]->id => ['orden' => 2, 'distancia' => 4.1],
            $est[2]->id => ['orden' => 3, 'distancia' => 8.3],
        ]);

        $busData = [
            ['linea_id' => $linea12->id,     'parqueo_id' => $parqueos[0]->id, 'placa' => 'P-001-GTM', 'capacidad_max' => 80],
            ['linea_id' => $linea12->id,     'parqueo_id' => $parqueos[0]->id, 'placa' => 'P-002-GTM', 'capacidad_max' => 80],
            ['linea_id' => $linea12->id,     'parqueo_id' => $parqueos[1]->id, 'placa' => 'P-003-GTM', 'capacidad_max' => 90],
            ['linea_id' => $linea12->id,     'parqueo_id' => $parqueos[1]->id, 'placa' => 'P-004-GTM', 'capacidad_max' => 90],
            ['linea_id' => $linea12->id,     'parqueo_id' => $parqueos[1]->id, 'placa' => 'P-005-GTM', 'capacidad_max' => 80],
            ['linea_id' => $ejeSur->id,      'parqueo_id' => $parqueos[2]->id, 'placa' => 'P-006-MXC', 'capacidad_max' => 100],
            ['linea_id' => $ejeSur->id,      'parqueo_id' => $parqueos[2]->id, 'placa' => 'P-007-MXC', 'capacidad_max' => 100],
            ['linea_id' => $ejeSur->id,      'parqueo_id' => $parqueos[2]->id, 'placa' => 'P-008-MXC', 'capacidad_max' => 80],
            ['linea_id' => $ejeSur->id,      'parqueo_id' => $parqueos[5]->id, 'placa' => 'P-009-MXC', 'capacidad_max' => 80],
            ['linea_id' => $lineaNorte->id,  'parqueo_id' => $parqueos[3]->id, 'placa' => 'P-010-VNV', 'capacidad_max' => 80],
            ['linea_id' => $lineaNorte->id,  'parqueo_id' => $parqueos[3]->id, 'placa' => 'P-011-VNV', 'capacidad_max' => 80],
            ['linea_id' => $lineaNorte->id,  'parqueo_id' => $parqueos[3]->id, 'placa' => 'P-012-VNV', 'capacidad_max' => 80],
            ['linea_id' => $lineaCentro->id, 'parqueo_id' => $parqueos[4]->id, 'placa' => 'P-013-VNV', 'capacidad_max' => 80],
            ['linea_id' => $lineaCentro->id, 'parqueo_id' => $parqueos[4]->id, 'placa' => 'P-014-VNV', 'capacidad_max' => 80],
            ['linea_id' => $lineaCentro->id, 'parqueo_id' => $parqueos[4]->id, 'placa' => 'P-015-VNV', 'capacidad_max' => 90],
            ['linea_id' => null,              'parqueo_id' => $parqueos[5]->id, 'placa' => 'P-016-RSV', 'capacidad_max' => 80],
        ];
        $buses = [];
        foreach ($busData as $b) { $buses[] = Bus::create($b); }

        foreach ([$linea12, $ejeSur, $lineaNorte, $lineaCentro] as $l) {
            $l->update(['cantidad_buses' => $l->buses()->count()]);
        }

        $pilotosData = [
            [$buses[0]->id,  'Juan Carlos Aju Lopez',    'Zona 3, Ciudad de Guatemala',  '5512-1001', 'jc.aju@transmetro.gob.gt'],
            [$buses[1]->id,  'Mario Roberto Cac Toj',    'Zona 6, Ciudad de Guatemala',  '5512-1002', 'mr.cac@transmetro.gob.gt'],
            [$buses[2]->id,  'Pedro Antonio Xol Choc',   'Mixco, Colonia El Milagro',    '5512-1003', 'pa.xol@transmetro.gob.gt'],
            [$buses[3]->id,  'Luis Enrique Batz Tzoc',   'Zona 12, Guatemala',           '5512-1004', 'le.batz@transmetro.gob.gt'],
            [$buses[4]->id,  'Carlos Alberto Yat Chub',  'Villa Nueva, Sector A',        '5512-1005', 'ca.yat@transmetro.gob.gt'],
            [$buses[5]->id,  'Sergio Ivan Cux Bal',      'Zona 5, Ciudad de Guatemala',  '5512-1006', 'si.cux@transmetro.gob.gt'],
            [$buses[6]->id,  'Roberto Josue Toj Aju',    'Mixco, Zona 4',                '5512-1007', 'rj.toj@transmetro.gob.gt'],
            [$buses[7]->id,  'Hector Manuel Choc Sic',   'Zona 8, Guatemala',            '5512-1008', 'hm.choc@transmetro.gob.gt'],
            [$buses[8]->id,  'Abelardo Jose Tzoc Batz',  'Villa Nueva, Zona 2',          '5512-1009', 'aj.tzoc@transmetro.gob.gt'],
            [$buses[9]->id,  'William Arturo Bal Caal',  'Zona 11, Guatemala',           '5512-1010', 'wa.bal@transmetro.gob.gt'],
            [$buses[10]->id, 'Edwin Rolando Caal Xol',   'Mixco, Col. San Francisco',    '5512-1011', 'er.caal@transmetro.gob.gt'],
            [$buses[11]->id, 'Nelson Ricardo Aju Boj',   'Villa Nueva, Sector B',        '5512-1012', 'nr.aju@transmetro.gob.gt'],
        ];
        foreach ($pilotosData as [$busId, $nombre, $dir, $tel, $email]) {
            $p = Piloto::create(['bus_id' => $busId, 'nombre' => $nombre, 'direccion' => $dir, 'telefono' => $tel, 'email' => $email]);
            HistorialEducativo::create(['piloto_id' => $p->id, 'institucion' => 'INTECAP', 'titulo' => 'Manejo de Transporte Urbano', 'anio_graduacion' => 2015]);
            HistorialEducativo::create(['piloto_id' => $p->id, 'institucion' => 'Instituto Rafael Aqueche', 'titulo' => 'Bachiller en Ciencias y Letras', 'anio_graduacion' => 2008]);
        }

        Operador::create(['nombre' => 'Administrador Municipal',   'usuario' => 'admin.municipal',   'password' => Hash::make('password123'), 'rol' => 'admin',      'estacion_id' => null]);
        Operador::create(['nombre' => 'Operador Estacion Central', 'usuario' => 'operador.central',  'password' => Hash::make('password123'), 'rol' => 'operador',   'estacion_id' => $est[0]->id]);
        Operador::create(['nombre' => 'Supervisor de Lineas',      'usuario' => 'supervisor.lineas', 'password' => Hash::make('password123'), 'rol' => 'supervisor', 'estacion_id' => null]);

        Alerta::create(['estacion_id' => $est[2]->id,  'tipo' => 'ocupacion', 'fecha_hora' => now()->subHours(2),              'atendida' => false]);
        Alerta::create(['estacion_id' => $est[4]->id,  'tipo' => 'ocupacion', 'fecha_hora' => now()->subHour(),                'atendida' => false]);
        Alerta::create(['estacion_id' => $est[9]->id,  'tipo' => 'ocupacion', 'fecha_hora' => now()->subMinutes(30),           'atendida' => false]);
        Alerta::create(['estacion_id' => $est[1]->id,  'tipo' => 'ocupacion', 'fecha_hora' => now()->subDays(1),               'atendida' => true, 'atendida_por' => 1]);
        Alerta::create(['estacion_id' => $est[11]->id, 'tipo' => 'ocupacion', 'fecha_hora' => now()->subDays(1)->subHours(3),  'atendida' => true, 'atendida_por' => 1]);

        RegistroEspera::create(['bus_id' => $buses[0]->id, 'estacion_id' => $est[0]->id, 'fecha_hora' => now()->subHours(3), 'minutos_espera' => 5]);
        RegistroEspera::create(['bus_id' => $buses[5]->id, 'estacion_id' => $est[4]->id, 'fecha_hora' => now()->subHours(1), 'minutos_espera' => 5]);
    }
}
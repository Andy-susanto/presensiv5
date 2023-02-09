<?php

use App\Http\Controllers\PresensiController;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/ldap', function () {
    // $ldapconn = ldap_connect('ldap://ldap.uinjambi.ac.id');
    // ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    // ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
    // $attributes = array('givenname', 'displayname', 'mail', 'memberof', 'description', 'cn', 'sn', 'employeetype', 'l');
    // // $ldapbind = ldap_bind($ldapconn, 'cn=admin,dc=ldap,dc=uinjambi,dc=ac,dc=id', 'UinJambi2019');
    // $req = @ldap_search($ldapconn,  "dc=ldap,dc=uinjambi,dc=ac,dc=id", '(cn=*2057201077*)', $attributes);
    // $first = ldap_first_entry($ldapconn, $req);
    // // return ldap_get_dn($ldapconn, $first);

    // $bind = ldap_bind($ldapconn, 'uid=201210001,ou=users,dc=ldap,dc=uinjambi,dc=ac,dc=id', '440200');


    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, "http://ldap.uinjambi.ac.id/index.php/servsso/sso/auth?uid=201210001&pwd=440200&token=84b0533db1b8976ba39a8344cf0e68b6");

    // curl_setopt($ch, CURLOPT_URL, "http://service.super.uinjambi.ac.id/servad/adgetuser.php?aud=f546d582bb59fdb81d6f680c5d2668bd45fa4742&src=201220011");

    // curl_setopt($ch, CURLOPT_URL, "http://service.super.uinjambi.ac.id/servad/adlogauthgr.php?aud=f546d582bb59fdb81d6f680c5d2668bd45fa4742&uss=201210001&pss=440200'");

    // return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    // tutup curl
    curl_close($ch);

    // menampilkan hasil curl
    print_r(json_decode($output));
});

Route::get('oracle', function () {
    return DB::connection('oracle')->table('TEMP_D_PGW_DETAIL')->limit('10')->get();
});
Route::get('/', [PresensiController::class, 'index']);
Route::get('/pegawai', [PresensiController::class, 'pegawai'])->name('load.pegawai');
Route::resource('presensi', PresensiController::class);

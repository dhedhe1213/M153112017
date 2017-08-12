<?php
/**
 * Created by PhpStorm.
 * User: Dede Irawan,S.kom
 * Date: 01/01/2002
 * Time: 0:20
 */
function form_rules_add_about()
{
    $form_rules = array(
        array(
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required' ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'required'),

    );

    return $form_rules;
}

function form_rules_add_cat()
{
    $form_rules = array(
        array(
            'field' => 'category',
            'label' => 'Category',
            'rules' => 'required' ),

    );

    return $form_rules;
}

function form_rules_edit_admin()
{
    $form_rules = array(
        array('field' => 'email',
              'label' => 'email',
              'rules' => 'required|trim|valid_email' ),
        array('field' => 'password',
              'label' => 'Password',
              'rules' => 'required|trim|min_length[6]|alpha_numeric',
              'errors' => array('alpha_numeric' => '%s hanya boleh berisi huruf dan angka')),
        array('field' => 're_password','label' => 'Confirm Password','rules' => 'required|trim|matches[password]' ),
    );

    return $form_rules;
}

function form_rules_edit_pass()
{
    $form_rules = array(
        array('field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim|min_length[6]|alpha_numeric',
            'errors' => array('alpha_numeric' => '%s hanya boleh berisi huruf dan angka')),
        array('field' => 're_password','label' => 'Ulangi Password','rules' => 'required|trim|matches[password]' ),
    );

    return $form_rules;
}

function form_rules_login()
{
    $form_rules = array(
        array('field' => 'email',
            'label' => 'email',
            'rules' => 'required|trim|valid_email' ),
        array(
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required|trim|alpha_numeric',
            'errors' => array(
            'alpha_numeric' => '%s hanya boleh berisi huruf dan angka',
            ),),
    );

    return $form_rules;
}

function form_rules_register()
{
    $form_rules = array(
        array('field' => 'name',
              'label' => 'Nama Lengkap',
              'rules' => 'required|trim|alpha_numeric_spaces',
              'errors' => array(
              'alpha_numeric_spaces' => '%s hanya boleh berisi huruf',
               )
        ),
        array('field' => 'phone',
              'label' => 'No.Handphone',
              'rules' => 'required|trim|numeric' ),
        array('field' => 'email',
              'label' => 'E-Mail',
              'rules' => 'required|trim|valid_email|is_unique[m_user.email]',
              'errors' => array('is_unique' => 'Alamat Email sudah digunakan' )
            ),
        array('field' => 'password',
              'label' => 'Password',
              'rules' => 'required|trim|min_length[6]|alpha_numeric',
              'errors' => array('alpha_numeric' => '%s hanya boleh berisi huruf dan angka')
            ),
        array('field' => 're_password',
              'label' => 'Ulangi Password',
              'rules' => 'required|trim|matches[password]' ),
        array('field' => 'date',
              'label' => 'Tanggal Lahir',
              'rules' => 'required|trim' ),
        array('field' => 'month',
              'label' => 'Bulan Lahir',
              'rules' => 'required|trim' ),
        array('field' => 'year',
              'label' => 'Tahun Lahir',
              'rules' => 'required|trim' ),
        array('field' => 'gender',
              'label' => 'Jenis Kelamin',
              'rules' => 'required|trim' )

    );

    return $form_rules;
}

function form_rules_edit_user()
{
    $form_rules = array(
        array('field' => 'name',
            'label' => 'Nama Lengkap',
            'rules' => 'required|trim|alpha_numeric_spaces',
            'errors' => array(
                'alpha_numeric_spaces' => '%s hanya boleh berisi huruf',
            )
        ),
        array('field' => 'phone',
            'label' => 'No.Handphone',
            'rules' => 'required|trim|numeric' ),
        array('field' => 'no_rek',
            'label' => 'No.Rekening',
            'rules' => 'required|trim|numeric' ),
        array('field' => 'nm_rek',
            'label' => 'Atas Nama Rekening',
            'rules' => 'required|trim|alpha_numeric_spaces',
            'errors' => array(
                'alpha_numeric_spaces' => '%s hanya boleh berisi huruf',
            )
        ),
        array('field' => 'date',
            'label' => 'Tanggal Lahir',
            'rules' => 'required|trim' ),
        array('field' => 'month',
            'label' => 'Bulan Lahir',
            'rules' => 'required|trim' ),
        array('field' => 'year',
            'label' => 'Tahun Lahir',
            'rules' => 'required|trim' ),
        array('field' => 'gender',
            'label' => 'Jenis Kelamin',
            'rules' => 'required|trim' )

    );

    return $form_rules;
}

function form_rules_add_review()
{
    $form_rules = array(
        array(
            'field' => 'name',
            'label' => 'Nama',
            'rules' => 'required|trim|min_length[6]|alpha_numeric_spaces',
            'errors' => array('alpha_numeric_spaces' => '%s hanya boleh berisi huruf dan angka')),
        array(
            'field' => 'review',
            'label' => 'Ulasan',
            'rules' => 'required|trim|alpha_numeric_spaces',
            'errors' => array('alpha_numeric_spaces' => '%s hanya boleh berisi huruf dan angka')),
        array(
            'field' => 'backing5',
            'label' => 'Rate',
            'rules' => 'required|trim'),

    );

    return $form_rules;
}

function form_rules_add_catalog()
{
    $form_rules = array(
        array(
            'field' => 'nm_catalog',
            'label' => 'Nama Catalog',
            'rules' => 'required|trim|min_length[5]|alpha_numeric|is_unique[t_catalog.nm_catalog]',
            'errors' => array('alpha_numeric' => '%s hanya boleh berisi huruf dan angka tidak boleh mengandung spasi',
                              'is_unique' => 'Maaf, %s sudah ada yang menggunakan :(')),

    );

    return $form_rules;
}

function form_rules_edit_jumlah()
{
    $form_rules = array(
        array(
            'field' => 'jumlah',
            'label' => 'Jumlah',
            'rules' => 'required|trim|numeric',
            'errors' => array('numeric' => '%s hanya boleh berisi angka tidak boleh mengandung spasi')),

    );

    return $form_rules;
}

function form_rules_tambahAlamat()
{
    $form_rules = array(
        array('field' => 'nama',
            'label' => 'Nama Lengkap',
            'rules' => 'required|trim|alpha_numeric_spaces',
            'errors' => array(
                'alpha_numeric_spaces' => '%s hanya boleh berisi huruf',
            )
        ),
        array('field' => 'phone',
            'label' => 'No.Handphone',
            'rules' => 'required|trim|numeric' ),
        array('field' => 'alamat',
            'label' => 'Alamat',
            'rules' => 'required|trim' ),
        array('field' => 'provinsi',
            'label' => 'Provinsi',
            'rules' => 'required|trim' ),
        array('field' => 'kabupaten',
            'label' => 'Kabupaten',
            'rules' => 'required|trim' ),
        array('field' => 'kecamatan',
            'label' => 'Kecamatan',
            'rules' => 'required|trim' ),


    );

    return $form_rules;
}

function form_rules_konfirmasi()
{
    $form_rules = array(
        array('field' => 'nama_bank_pengirim',
            'label' => 'Nama Bank Pengirim',
            'rules' => 'required|trim',

        ),
        array('field' => 'nama_rekening_pengirim',
            'label' => 'Nama Rekening Pengirim',
            'rules' => 'required|trim|alpha_numeric_spaces',
            'errors' => array(
                'alpha_numeric_spaces' => '%s hanya boleh berisi huruf',
            )
        ),
        array('field' => 'nama_bank_tujuan',
            'label' => 'Nama Bank Tujuan',
            'rules' => 'required|trim',

        ),
        array('field' => 'jml_transfer',
            'label' => 'Jumlah Transfer',
            'rules' => 'required|trim|numeric'
        ),
        array('field' => 'nomor_rekening_pengirim',
            'label' => 'Nomor Rekening Pengirim',
            'rules' => 'required|trim|numeric' ),


    );

    return $form_rules;
}

function form_rules_input_resi()
{
    $form_rules = array(

        array('field' => 'no_resi',
            'label' => 'Nomor Resi',
            'rules' => 'required|trim'),
    );

    return $form_rules;
}

function form_rules_tambah_barang()
{
    $form_rules = array(
        array('field' => 'nama_barang',
            'label' => 'Nama Barang',
            'rules' => 'required|trim',
        ),
        array('field' => 'category1',
            'label' => 'Kategori',
            'rules' => 'required|trim'
        ),
        array('field' => 'category2',
            'label' => 'Kategori',
            'rules' => 'required|trim'
        ),
        array('field' => 'category3',
            'label' => 'Kategori',
            'rules' => 'required|trim'
        ),
        array('field' => 'stok',
            'label' => 'Stok',
            'rules' => 'required|trim|numeric' ),
        array('field' => 'berat',
            'label' => 'Berat',
            'rules' => 'required|trim|numeric' ),
        array('field' => 'min_pesan',
            'label' => 'Minimal Pesan',
            'rules' => 'required|trim|numeric' ),
        array('field' => 'deskripsi',
            'label' => 'Deskripsi',
            'rules' => 'required|trim'
        ),
        array('field' => 'harga_barang',
            'label' => 'Harga Barang',
            'rules' => 'required|trim|numeric' ),
        array('field' => 'harga_coret',
            'label' => 'Harga Coret',
            'rules' => 'trim|numeric' ),
        array('field' => 'komisi_reseller',
            'label' => 'Komisi Reseller',
            'rules' => 'required|trim|numeric' )

    );

    return $form_rules;
}


#################### BATAS RULE DAN FUNCTION VALIDASI ##############################################

function validation_login()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_login();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_edit_admin()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_edit_admin();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_register()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_register();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_edit_user()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_edit_user();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_edit_pass()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_edit_pass();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_add_about()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_add_about();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_add_cat()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_add_cat();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_add_review()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_add_review();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_add_catalog()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_add_catalog();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_edit_jumlah()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_edit_jumlah();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_TambahAlamat()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_tambahAlamat();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_konfirmasi()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_konfirmasi();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_input_resi()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_input_resi();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function validation_tambah_barang()
{
    $ci = &get_instance();
    $ci->load->library('form_validation');
    $form = form_rules_tambah_barang();

    $ci->form_validation->set_rules($form);
    if($ci->form_validation->run())
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}



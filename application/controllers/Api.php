<?php

require_once APPPATH . 'libraries/REST_Controller.php';

use MP_kanpa\Libraries\REST_Controller;

class Api extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
		$this->load->model('GenerateKey_model');
		$this->verify_api_key();
    }

    private function verify_api_key()
    {
        $api_key = $this->input->get_request_header('X-API-KEY', TRUE);

        if (!$api_key) {
            $this->response(array('status' => 'unauthorized', 'message' => 'API Key is missing'), 401);
            return FALSE;
        }

        $key_status = $this->GenerateKey_model->is_valid_key($api_key);

        if ($key_status === 'inactive') {
            $this->response(array('status' => 'unauthorized', 'message' => 'API Key is inactive'), 401);
            return FALSE;
        } elseif ($key_status === FALSE) {
            $this->response(array('status' => 'unauthorized', 'message' => 'Invalid API Key'), 401);
            return FALSE;
        }

        return TRUE;
    }

    function properti_get()
    {
        if (!$this->verify_api_key()) return;

        $id = $this->get('id_properti');

        $this->db->select('
            properti.id_properti,
            properti.judul_properti,
            properti.jenis_penawaran,
            properti.alamat,
            properti.lokasi,
            properti.area_terdekat,
            properti.viewer,
            properti.dibuat,
            status_properti.status,
            detail_properti.jml_kamar,
            detail_properti.jml_kamar_mandi,
            detail_properti.luas_bangunan,
            detail_properti.luas_tanah,
            detail_properti.daya_listrik,
            detail_properti.carport,
            detail_properti.ruang_tamu,
            detail_properti.ruang_keluarga,
            detail_properti.taman,
            detail_properti.level,
            detail_properti.ruang_makan,
            detail_properti.balkon,
            detail_properti.harga,
            detail_properti.satuan,
            detail_properti.deskripsi,
            GROUP_CONCAT(gambar_properti.gambar) as gambar,
            fasilitas_properti.jalan,
            fasilitas_properti.masjid,
            fasilitas_properti.taman_bermain,
            fasilitas_properti.area_ruko,
            fasilitas_properti.kolam_renang,
            fasilitas_properti.one_gate,
            fasilitas_properti.security,
            fasilitas_properti.cctv,
            type_properti.nama_type,
            type_properti.icon,
            wilayah_kota.nama_kota,
            wilayah_kota.provinsi_id,
            wilayah_provinsi.nama as nama_provinsi,
            agency.nama_agent,
            agency.email,
            agency.position,
            agency.no_tlp,
            agency.foto_profil,
            agency.alamat as agency_alamat,
            filter_kota.icon as icon_filter,
            promo.nama_promo,
            meta_properti.foto_meta
        ');

        $this->db->from('properti');
        $this->db->join('status_properti', 'status_properti.id_status = properti.id_status');
        $this->db->join('detail_properti', 'detail_properti.id_properti = properti.id_properti', 'left');
        $this->db->join('gambar_properti', 'gambar_properti.id_properti = properti.id_properti', 'left');
        $this->db->join('meta_properti', 'meta_properti.id_properti = properti.id_properti', 'left');
        $this->db->join('fasilitas_properti', 'fasilitas_properti.id_properti = properti.id_properti', 'left');
        $this->db->join('type_properti', 'type_properti.id_type = properti.id_type', 'left');
        $this->db->join('wilayah_kota', 'wilayah_kota.id_kota = properti.id_kota', 'left');
        $this->db->join('wilayah_provinsi', 'wilayah_provinsi.id = wilayah_kota.provinsi_id', 'left');
        $this->db->join('listing', 'listing.id_properti = properti.id_properti', 'left');
        $this->db->join('agency', 'agency.id_agency = listing.id_agency', 'left');
        $this->db->join('filter_kota', 'filter_kota.id_kota = properti.id_kota', 'left');
        $this->db->join('promo', 'promo.id_properti = properti.id_properti', 'left');

        if ($id) {
            $this->db->where('properti.id_properti', $id);
        }

        $this->db->group_by('properti.id_properti');

        $customer = $this->db->get()->result();

        if ($customer) {
            $this->response($customer, 200);
        } else {
            $this->response(array('status' => 'not found'), 404);
        }
    }

    function properti_put()
    {
        if (!$this->verify_api_key()) return;

        $params = array(
            'viewer' => $this->put('viewer'),
        );
        $this->db->where('id_properti', $this->put('id_properti'));
        $execute = $this->db->update('properti', $params);
        if ($execute) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail'), 502);
        }
    }

    function reels_get()
    {
        if (!$this->verify_api_key()) return;

        $id = $this->get('id_reel');

        $this->db->select('
            reels.id_reel,
            reels.id_properti,
            reels.judul_reels,
            reels.video,
            reels.sosial_media,
            reels.deskripsi,
            reels.uploaded,
            reels.views,
            properti.id_properti,
            properti.judul_properti,
            properti.alamat,
            properti.jenis_penawaran,
            properti.area_terdekat,
            agency.nama_agent,
            agency.no_tlp,
            agency.foto_profil,
            agency.alamat as agency_alamat,
            detail_properti.jml_kamar,
            detail_properti.jml_kamar_mandi,
            detail_properti.luas_bangunan,
            detail_properti.luas_tanah,
            detail_properti.harga,
            detail_properti.satuan,
            type_properti.nama_type,
            wilayah_kota.nama_kota
        ');
        $this->db->from('reels');
        $this->db->join('properti', 'properti.id_properti = reels.id_properti', 'left');
        $this->db->join('wilayah_kota', 'wilayah_kota.id_kota = properti.id_kota', 'left');
        $this->db->join('detail_properti', 'detail_properti.id_properti = properti.id_properti', 'left');
        $this->db->join('listing', 'listing.id_properti = properti.id_properti', 'left');
        $this->db->join('type_properti', 'type_properti.id_type = properti.id_type', 'left');
        $this->db->join('agency', 'agency.id_agency = listing.id_agency', 'left');

        if ($id) {
            $this->db->where('reels.id_reel', $id);
        }

        $this->db->order_by("reels.id_reel", "DESC");
        $reels = $this->db->get()->result();

        if ($reels) {
            $this->response($reels, 200);
        } else {
            $this->response(array('status' => 'not found'), 404);
        }
    }

    function banner_get()
    {
        if (!$this->verify_api_key()) return;

        $id = $this->get('id_banner');

        $this->db->select('
            banner.id_banner,
            banner.id_properti,
            banner.type_banner,
            banner.jenis_penawaran,
            banner.foto_banner,
            banner.created,
            properti.judul_properti,
            properti.id_properti
        ');
        $this->db->from('banner');
        $this->db->join('properti', 'properti.id_properti = banner.id_properti', 'left');

        if ($id) {
            $this->db->where('banner.id_banner', $id);
        }

        $this->db->order_by("banner.id_banner", "DESC");
        $banner = $this->db->get()->result();

        if ($banner) {
            $this->response($banner, 200);
        } else {
            $this->response(array('status' => 'not found'), 404);
        }
    }

    function agency_get()
    {
        if (!$this->verify_api_key()) return;

        $id = $this->get('id_agency');

        $this->db->select('
            agency.id_agency,
            agency.nama_agent,
            agency.position,
            agency.alamat,
            agency.no_tlp,
            agency.email,
            agency.foto_profil,
            agency.created,
            COUNT(listing.id_listing) as total_listing,
            GROUP_CONCAT(properti.judul_properti) as nama_properti
        ');
        $this->db->from('agency');
        $this->db->join('listing', 'listing.id_agency = agency.id_agency', 'left');
        $this->db->join('properti', 'properti.id_properti = listing.id_properti', 'left');

        if ($id) {
            $this->db->where('agency.id_agency', $id);
        }

        $this->db->where('agency.position !=', 'Admin');

        $this->db->group_by('agency.id_agency');
        $this->db->order_by("agency.id_agency", "DESC");

        $agency = $this->db->get()->result();

        if ($agency) {
            $this->response($agency, 200);
        } else {
            $this->response(array('status' => 'not found'), 404);
        }
    }

	// 	API Maps

    public function mapdata_get()
    {
        $api_key_status = $this->verify_api_key();

        if ($api_key_status !== TRUE) {
            return;
        }

        $id = $this->get('id');

        $this->db->select('
            map.id,
            map.id_prov,
            wilayah_provinsi.nama as nama_provinsi,
            map.svg_map
        ');
        $this->db->from('map');
        $this->db->join('wilayah_provinsi', 'wilayah_provinsi.id = map.id_prov');

        if ($id) {
            $this->db->where('map.id', $id);
        }

        $this->db->group_by('map.id');
        $this->db->order_by("map.id", "ASC");

        $result = $this->db->get()->result();

        if ($result) {
            $this->response($result, 200);
        } else {
            $this->response(array('status' => 'not found', 'message' => 'Data not found'), 404);
        }
    }

	function map_get()
	{
		if (!$this->verify_api_key()) return;

		$id = $this->get('id');

		$this->db->select('
			map.id,
			map.id_prov,
			wilayah_provinsi.nama as nama_provinsi,
			map.svg_map,
		');
		$this->db->from('map');
		$this->db->join('wilayah_provinsi', 'wilayah_provinsi.id = map.id_prov');

		if ($id) {
			$this->db->where('map.id', $id);
		}

		$this->db->group_by('map.id');
		$this->db->order_by("map.id", "ASC");

		$maps = $this->db->get()->result();

		if ($maps) {
			$this->response(array('status' => 'success', 'data' => $maps), 200);
		} else {
			$this->response(array('status' => 'not found', 'message' => 'Data tidak ditemukan'), 404);
		}
	}

	function map_post()
	{
		if (!$this->verify_api_key()) return;

		$id = $this->post('id');

		$this->db->select('
			map.id,
			map.id_prov,
			wilayah_provinsi.nama as nama_provinsi,
			map.svg_map,
		');
		$this->db->from('map');
		$this->db->join('wilayah_provinsi', 'wilayah_provinsi.id = map.id_prov');

		if ($id) {
			$this->db->where('map.id', $id);
		}

		$this->db->group_by('map.id');
		$this->db->order_by("map.id", "ASC");

		$agent = $this->db->get()->result();

		if ($agent) {
			$this->response(array('data' => $agent), 200);
		} else {
			$this->response(array('status' => 'not found'), 404);
		}
	}

	function mapcolor_get()
	{
		if (!$this->verify_api_key()) return;

		$id = $this->get('id');

		$this->db->select('
			data_map.id,
			data_map.id_prov,
			data_map.code,
			data_map.color
		');
		$this->db->from('data_map');

		if ($id) {
			$this->db->where('data_map.id', $id);
		}

		$maps_data = $this->db->get()->result();

		if ($maps_data) {
			$this->response(array('status' => 'success', 'data' => $maps_data), 200);
		} else {
			$this->response(array('status' => 'not found', 'message' => 'Data tidak ditemukan'), 404);
		}
	}

    function data_article_get()
    {
        if (!$this->verify_api_key()) return;

        $id = $this->get('id_data_berita');

        $this->db->select('
            data_berita.id_data_berita,
            data_berita.berita_id,
            data_berita.text_berita,
            COALESCE(foto_berita.file_foto_berita, "") as file_foto_berita,
            data_berita.file_foto_btn,
            data_berita.link_btn
        ');

        $this->db->from('data_berita');
        $this->db->join('foto_berita', 'foto_berita.data_berita_id = data_berita.id_data_berita', 'left');

        if ($id) {
            $this->db->where('data_berita.id_data_berita', $id);
        }

        $berita = $this->db->get()->result();

        if ($berita) {
            $this->response($berita, 200);
        } else {
            $this->response(array('status' => 'not found'), 404);
        }
    }

    // article api

    function article_get()
    {
        if (!$this->verify_api_key()) return;

        $id = $this->get('id_berita');

        $this->db->select('
            berita.id_berita,
            berita.judul_berita,
            berita.tgl_berita,
            berita.meta_desk,
            berita.tag_berita,
            berita.foto_berita,
            berita.meta_foto,
            berita.view_berita
        ');

        $this->db->from('berita');

        if ($id) {
            $this->db->where('berita.id_berita', $id);
        }

        $berita = $this->db->get()->result();

        if ($berita) {
            $this->response($berita, 200);
        } else {
            $this->response(array('status' => 'not found'), 404);
        }
    }

    function article_put()
    {
        if (!$this->verify_api_key()) return;

        $params = array(
            'viewer_berita' => $this->put('viewer_berita'),
        );
        $this->db->where('id_berita', $this->put('id_berita'));
        $execute = $this->db->update('berita', $params);
        if ($execute) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail'), 502);
        }
    }

    // meta properti APi
    function meta_get()
    {
        if (!$this->verify_api_key()) return;

        $id = $this->get('id_meta');

        $this->db->select('
            meta_properti.id_meta,
            meta_properti.id_properti,
            meta_properti.foto_meta,
            properti.judul_properti
        ');
        $this->db->from('meta_properti');
        $this->db->join('properti', 'properti.id_properti = meta_properti.id_properti', 'left');

        if ($id) {
            $this->db->where('meta_properti.id_meta', $id);
        }

        $this->db->order_by("meta_properti.id_meta", "DESC");
        $meta = $this->db->get()->result();

        if ($meta) {
            $this->response($meta, 200);
        } else {
            $this->response(array('status' => 'not found'), 404);
        }
    }

}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends Base_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('General_model');
        $this->load->model('Base_model');
        $this->load->model('News_model');
        $this->load->library('form_validation');
    }

    public function index($id = "") {
        $this->page_data['page_title'] = "Content";
        $user_id = $this->session->userdata('user_id');
        $this->page_data['news_id'] = $id;
        if (empty($id)) {
            $this->page_data['action'] = 'Add ';
        } else {
            $this->page_data['action'] = 'Edit ';
        }
        if ($this->input->post()) {
            $this->form_validation->set_rules('news_title', 'News Title', 'trim|required');
            $this->form_validation->set_rules('news_permalink', 'News Url', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('news_category_id', 'News Category', 'trim|required');
            $this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required');
            $this->form_validation->set_rules('meta_keyword', 'Meta Keyword', 'trim|required');
            $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required');

            $news_id = $this->input->post('hdn_news_id');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', validation_errors());
            } else {
                $data['created_by'] = $user_id;
                $data['news_title'] = $this->input->post('news_title');
                $news_permalink = $this->input->post('news_permalink');
                $data['news_permalink'] = $this->General_model->create_url($news_permalink);
                $data['description'] = $this->input->post('description');
                $data['news_category_id'] = $this->input->post('news_category_id');
                $data['news_subcategory_id'] = $this->input->post('news_subcategory_id');
                $data['is_active'] = 1;
                $meta_data['meta_description'] = $this->input->post('meta_description');
                $meta_data['meta_keyword'] = $this->input->post('meta_keyword');
                $meta_data['meta_title'] = $this->input->post('meta_title');
                $meta_data['is_active'] = 1;
                $main_cat_name=$this->input->post('main_category_name_hidden');
                if (!$news_id) {
                    $meta_id = $this->Base_model->insert_entry('meta', $meta_data);
                    $data['meta_id'] = $meta_id;
                    $data['created_time'] = time();
                    $news_id = $this->Base_model->insert_entry('news', $data); 
                    if($main_cat_name == "Product"){
                        $proddata['cat_id'] = $this->input->post('product_category_id');
                        $proddata['sub_cat_id'] = $this->input->post('product_subcategory_id');
                        $proddata['news_id'] = $news_id;
                        $this->Base_model->insert_entry('content_product_mapping', $proddata);
                    }
                    $msg = "added";
                }else {
                    $meta_id = $this->input->post('hdn_meta_id');
                    $this->Base_model->update_entry('meta', $meta_data, 'meta_id', $meta_id);
                    $this->Base_model->update_entry('news', $data, 'news_id', $news_id);
                     if($main_cat_name == "Product"){
                        $proddata['cat_id'] = $this->input->post('product_category_id');
                        $proddata['sub_cat_id'] = $this->input->post('product_subcategory_id');
                        $this->Base_model->update_entry('content_product_mapping', $proddata, 'news_id', $news_id);
                        }
                    $msg = "updated";
                }
                
                if ($news_id) {
                    if (isset($_FILES['news_image']) && !empty($_FILES['news_image']['tmp_name'])) {
                        $config['allowed_types'] = 'jpg|png|jpeg|gif';
                        $upload_return = $this->General_model->do_upload('news_image', $_FILES['news_image'], 'news', $config);

                        if (!empty($upload_return['error'])) {
                            $this->session->set_flashdata('error_msg', $upload_return['error']);
                            redirect('admin/news');
                        } else {
                            $file_data['news_id'] = $news_id;
                            $file_data['image_path'] = $upload_return['data']['file_name'];
                            $file_data['created_by'] = $user_id;
                            $file_data['created_time'] = time();
                            $file_data['is_active'] = '1';
                            if (!$this->input->post('hdnImage')) {
                                $this->Base_model->insert_entry('news_images', $file_data);
                            } else {
                                $this->Base_model->update_entry('news_images', $file_data, 'news_id', $news_id);
                            }
                        }
                    }
                    $this->page_data['success_msg'] = '<div class="alert alert-success text-center">Content '.$msg.' successfully!</div>';
                    
                    $this->session->set_flashdata('succes_message', $this->page_data['success_msg']);
                    redirect("admin/content/".$news_id);
                }
            }
        }
        $this->page_data['news_categories'] = $this->Base_model->get_all("news_category");
        if ($this->page_data['news_id'] != "") {
            $this->page_data['news_data'] = $this->News_model->get_news_data($id);
            $this->page_data['news_subcategories'] = $this->Base_model->get_list("news_subcategory",'*',array('news_category_id'=>$this->page_data['news_data']->news_category_id));
            $this->page_data['product_subcategories'] = $this->Base_model->get_list("sub_categories",'*',array('cat_id'=>$this->page_data['news_data']->cat_id)); 

        }
        $this->page_data['product_categories'] = $this->General_model->get_all_categories();
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/news', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

    public function news_list($page = 1) {
        $this->page_data['page_title'] = "News";
        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $url = base_url() . "/admin/view-content/";
        $this->page_data['per_page'] = "10";
        $cnt = $this->News_model->get_all_news_count();
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['news_list'] = $this->News_model->get_all_news($offset, $this->page_data['per_page']);
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/news_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

    public function news_delete($id) {
        $this->Base_model->delete_entry('news', array('news_id' => $id));
        $this->Base_model->delete_entry('news_images', array('news_id' => $id));
        redirect('admin/view-content');
    }

    public function category($id = "") {
        $this->page_data['page_title'] = "Content Category";
        $this->page_data['action'] = "Add";
        $this->page_data['cat_id'] = $id;
        if ($this->input->post()) {
            $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', validation_errors());
            } else {
                $data['created_by'] = $this->session->userdata('user_id');
                $data['created_time'] = time();
                $data['category_name'] = $this->input->post('category_name');
                $data['description'] = $this->input->post('description');
                $data['is_active'] = 1;
                if (!$this->input->post('news_category_id')) {
                    $cat_id = $this->Base_model->insert_entry('news_category', $data);
                    $msg = "added";
                } else {
                    $cat_id = $this->input->post('news_category_id');
                    $this->Base_model->update_entry('news_category', $data, 'news_category_id', $cat_id);
                    $msg = "updated";
                }
                if ($cat_id) {
                    $this->page_data['success_msg'] = '<div class="alert alert-success text-center">Content category '.$msg.' successfully!</div>';
                }
            }
        }
        $this->page_data['category_name'] = "";
        $this->page_data['description'] = "";
        if ($id) {
            $this->page_data['action'] = "Edit";
            $news_category = $this->Base_model->get_one_entry("news_category", array('news_category_id' => $id));
            if ($news_category) {
                $this->page_data['category_name'] = $news_category->category_name;
                $this->page_data['description'] = $news_category->description;
            }
        }
        $nws_cat = ($this->input->post('news_category_id'))? $this->input->post('news_category_id'): "";
        if($nws_cat){
            $this->session->set_flashdata('succes_message', $this->page_data['success_msg']);
            redirect("admin/news-category/".$nws_cat,$this->page_data);  
        }
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/news_category', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

    public function category_list() {
        $this->page_data['page_title'] = "Content Category";
        $this->page_data['news_categories'] = $this->Base_model->get_all("news_category");
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/news_category_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

    public function news_category_delete($id) {
        $this->Base_model->delete_entry('news_category', array('news_category_id' => $id));
        redirect('admin/view-category');
    }
    
    public function subcategory($id = "") {
        $this->page_data['page_title'] = "Content Subcategory";
        $this->page_data['action'] = "Add";
        $this->page_data['subcat_id'] = $id;
        if ($this->input->post()) {
            $this->form_validation->set_rules('subcategory_name', 'Subcategory Name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', validation_errors());
            } else {
                $data['created_by'] = $this->session->userdata('user_id');
                $data['created_time'] = time();
                $data['subcategory_name'] = $this->input->post('subcategory_name');
                $data['news_category_id'] = $this->input->post('news_category_id');
                $data['description'] = $this->input->post('description');
                $data['is_active'] = 1;
                if (!$this->input->post('news_subcategory_id')) {
                    $subcat_id = $this->Base_model->insert_entry('news_subcategory', $data);
                    $msg = "added";
                } else {
                    $subcat_id = $this->input->post('news_subcategory_id');
                    $this->Base_model->update_entry('news_subcategory', $data, 'news_subcategory_id', $subcat_id);
                    $msg = "updated";
                }
                if ($subcat_id) {
                    $this->page_data['success_msg'] = '<div class="alert alert-success text-center">Subcategory '.$msg.' successfully!</div>';
                }
            }
        }
        $this->page_data['subcategory_name'] = "";
        $this->page_data['description'] = "";
        $this->page_data['news_categories'] = $this->Base_model->get_all("news_category");
        if ($id) {
            $this->page_data['action'] = "Edit";
            $news_subcategory = $this->Base_model->get_one_entry("news_subcategory", array('news_subcategory_id' => $id));
            if ($news_subcategory) {
                $this->page_data['news_category_id'] = $news_subcategory->news_category_id;
                $this->page_data['subcategory_name'] = $news_subcategory->subcategory_name;
                $this->page_data['description'] = $news_subcategory->description;
            }
        }
        $nws_subcat = ($this->input->post('news_subcategory_id'))? $this->input->post('news_subcategory_id'): "";
        if($nws_subcat){
            $this->session->set_flashdata('succes_message', $this->page_data['success_msg']);
            redirect("admin/news-subcategory/".$nws_subcat,$this->page_data);  
        }
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/news_subcategory', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    
    public function subcategory_list() {
        $this->page_data['page_title'] = "Content Subcategory";
        $this->page_data['news_subcategories'] = $this->Base_model->get_all("news_subcategory");
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/news_subcategory_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    
    public function subcategory_delete($id) {
        $this->Base_model->delete_entry('news_subcategory', array('news_subcategory_id' => $id));
        redirect('admin/view-subcategory');
    }
    public function ajax_subcategories() {
        $cat_id = $this->input->post('cat_id');
        $news_subcategories = $this->Base_model->get_list("news_subcategory",'*',array('news_category_id'=>$cat_id));
        //print_r($this->page_data['news_subcategories']);
        $strSubcate = '<select class="form-control" name="news_subcategory_id" id="news_subcategory_id"><option value="0">-- Select --</option>';
            if($news_subcategories){
             foreach ($news_subcategories as $subcategory) {
                $strSubcate .= '<option value="' . $subcategory->news_subcategory_id . '">' . $subcategory->subcategory_name . '</option>';
             }
           }
        $strSubcate .= '</select>';
        echo $strSubcate;
    }
    
    public function tags() {
        $this->page_data['page_title'] = "Content Tags";
        if ($this->input->post()) {
            $this->form_validation->set_rules('tag_name', 'Tag Name', 'trim|required');
            if ($this->form_validation->run() === FALSE) {
                $this->session->set_flashdata('error_msg', validation_errors());
            } else {
                $data['created_by'] = $this->session->userdata('user_id');
                $data['created_time'] = time();
                $data['tag_name'] = $this->input->post('tag_name');
                $data['is_active'] = 1;
                $tag_id = $this->Base_model->insert_entry('tags', $data);
                if ($tag_id) {
                    $this->page_data['success_msg'] = '<div class="alert alert-success text-center">Tag added successfully!</div>';
                }
            }
        }
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/news_tags', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }
    
    public function news_comment(){
        
        $data['news_id'] = $this->input->post('news_id');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['description'] = $this->input->post('comment');
        $data['created_time'] = time();
        $data['is_active'] = 1;
        $this->session->set_flashdata('comment_message', 'Thank you for your post! Your comment will be reviewed by our moderator and posted momentarily. Kind Regards, the SMARTCardMarket team.');
        $this->Base_model->insert_entry('news_comments', $data);
        redirect('news_view/'.$data['news_id']);
    }

     public function news_comment_list($page = 1){

        $this->page_data['page_title'] = "News Comments";
        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $url = base_url() . "/admin/news_comment_list/";
        $this->page_data['per_page'] = "10";
        $cnt = $this->News_model->get_admin_news_comment_count();
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['news_comment_list'] = $this->News_model->get_admin_news_comment($offset, $this->page_data['per_page']);

        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/news_comment_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');

     }


     public function approve_news_comment($id) {
        $this->session->set_flashdata('message', 'Comment Approved successfully');
        $this->Base_model->update_entry('news_comments',array('is_moderated'=>'1'), 'news_comment_id', $id);
        redirect('admin/news_comment_list');
    }

    public function reject_news_comment($id) {
        $this->session->set_flashdata('message', 'Comment Rejected successfully');
        $this->Base_model->update_entry('news_comments',array('is_moderated'=>'0'), 'news_comment_id', $id);
        redirect('admin/news_comment_list');
    }

    public function delete_news_comment($id) {
        $this->session->set_flashdata('message', 'Comment Deleted successfully');
        $this->Base_model->delete_entry('news_comments', array('news_comment_id' => $id));
       
        redirect('admin/news_comment_list');
    }
    public function product_list($page = 1) {
        $this->page_data['page_title'] = "News";
        $this->load->model("Pagination_model");
        $this->page_data['page_num'] = $page;
        $url = base_url() . "/admin/product_list/";
        $this->page_data['per_page'] = "10";
        $cnt = $this->News_model->get_all_product_count();
        $this->Pagination_model->init_pagination($url, $cnt, $this->page_data['per_page']);
        $this->page_data['tot_count'] = $cnt;
        $this->page_data["pagination_helper"] = $this->pagination;
        $offset = ($page - 1) * $this->page_data['per_page'];
        $this->page_data['product_list'] = $this->News_model->get_all_product($offset, $this->page_data['per_page']);
        $this->load->view('templates/top');
        $this->load->view('templates/head', $this->page_data);
        $this->load->view('templates/header_dashboard', $this->page_data);
        $this->load->view('admin/product_list', $this->page_data);
        $this->load->view('templates/footer_dashboard');
        $this->load->view('templates/bottom');
    }

    public function product_delete($id) {
        $this->Base_model->delete_entry('news', array('news_id' => $id));
        $this->Base_model->delete_entry('news_images', array('news_id' => $id));
        $this->Base_model->delete_entry('content_product_mapping', array('news_id' => $id));
        redirect('admin/product_list');
    }
}

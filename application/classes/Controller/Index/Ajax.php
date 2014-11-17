<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Головна сторінка
 */
class Controller_Index_Ajax extends Controller {
    
    public function before() {
        parent::before();
    }
    
    public function action_index() {
        
    }
    
    public function action_remain() {
        $Useful = new Model_Useful();
        $Storecity = new Model_Storecity();
        $Remain = new Model_Remain();
        $data = Arr::extract($_POST, array('date_from', 'date_to', 'store_city_id', 'company_id', 'store_city_sum', 'company_sum', 'button'));
        $data = Security::xss_clean($data);
        $errors = array();
        if (!empty($data['button'])) {
            /*$data['store_city_id'] = 'FB728993-C2D2-4DDF-A554-FEFF595A37E2,D0828A65-3967-4F9C-B8FD-3F93D8047347,2052FF30-31C8-4DE0-AA02-CB62D209807D,EDB412EC-A4AA-44D4-BE40-A4B5C0418C8C,5C901735-D844-48E8-BF9B-E616DFBFAC26,5A110628-F072-4D70-9F4E-D40DC34FAF49,AD9F65C9-E18B-47AB-9DA7-F18F0245D1F7,A6A000EC-E550-4945-ADB5-3CC5F533E714,43104D06-BFC8-416C-9DEF-25CC4EE32E05,6F2E0E40-CD44-41CB-B7D5-0503B6A1E027,57D7D509-6CC4-426F-90AB-494FC0455371,810CF7FB-73BB-49E3-A923-E37E8FB27423,C87F62DF-3A1E-434F-9AFD-E30406A0792E,7DB90974-CF77-4436-90E2-1688502E77FB,C49EB139-1FA9-4260-B783-793FA67EE9A6,08C648FE-F77A-43A5-BDDC-4C2F3CAB2A8B,0BCCDD75-EAC7-40CC-8851-3F2FD89B7DFB';
            $data['company_id'] = '1';
            $data['company_sum'] = 'false';
            $data['store_city_sum'] = 'true';
            $data['date_from'] = '2014-07-02';
            $data['date_to'] = '2014-07-13';*/
            
            
            $name = null;
            $table_graph = null;
            $table_table = null;
            $validate = Validation::factory($data)
                ->rules('date_from', array(array('not_empty'), array('date')))
                ->rules('date_to', array(array('not_empty'), array('date')))
                ->rules('store_city_id', array(array('not_empty')))
                ->rules('company_id', array(array('not_empty')))
            
                ->labels(array(
                    'date_from' => 'Date from',
                    'date_to' => 'Date to',
                    'store_city_id' => 'Department',
                    'company_id' => 'Entrepreneur',
                    ));
            if ($validate->check()) {
                if ($data['store_city_sum'] == 'true' && $data['company_sum'] == 'true') {
                    $name1 = implode(", ", $Storecity->getStoreCityName($data['store_city_id']));
                    $name2 = implode(", ", $Storecity->getStoreCityIndexName($data['company_id']));
                    $name = "<p><strong><span><u>Department</u></span></strong>: <strong>Σ</strong> ($name1)</p>
                    <p><strong><span><u>Entrepreneur</u></span></strong>: <strong>Σ</strong> ($name2)</p>";
                    $remain_graph = $Remain->getRemainGraph($data['date_from'], $data['date_to'], null, null, 9);
                    $table_graph = Useful::set_table_remain_sum_json($remain_graph);
                } elseif (($data['store_city_sum'] == 'true' || (count(explode(",", $data['store_city_id'])) == 1)) && $data['company_sum'] == 'false') {
                    $data['store_city_sum'] == 'true' ? $sum1 = '<strong>Σ</strong>' : $sum1 = '';
                    $data['company_sum'] == 'true' ? $sum2 = '<strong>Σ</strong>' : $sum2 = '';
                    $name1 = implode(", ", $Storecity->getStoreCityName($data['store_city_id']));
                    $name2 = implode(", ", $Storecity->getStoreCityIndexName($data['company_id']));
                    $name = "<p><strong><span><u>Department</u></span></strong>: $sum1 ($name1)</p>
                    <p><strong><span><u>Entrepreneur</u></span></strong>: $sum2 ($name2)</p>";
                    $remain_graph = $Remain->getRemainGraph($data['date_from'], $data['date_to'], $data['store_city_id'], $data['company_id'], 10);
                    $table_graph = Useful::set_table_one_sum_json($remain_graph);    
                    
                } elseif (($data['company_sum'] == 'true' || (count(explode(",", $data['company_id'])) == 1)) && $data['store_city_sum'] == 'false') {
                    $data['store_city_sum'] == 'true' ? $sum1 = '<strong>Σ</strong>' : $sum1 = '';
                    $data['company_sum'] == 'true' ? $sum2 = '<strong>Σ</strong>' : $sum2 = '';
                    $name1 = implode(", ", $Storecity->getStoreCityName($data['store_city_id']));
                    $name2 = implode(", ", $Storecity->getStoreCityIndexName($data['company_id']));
                    $name = "<p><strong><span><u>Department</u></span></strong>: $sum1 ($name1)</p>
                    <p><strong><span><u>Entrepreneur</u></span></strong>: $sum2 ($name2)</p>";
                    $remain_graph = $Remain->getRemainGraph($data['date_from'], $data['date_to'], $data['store_city_id'], $data['company_id'], 11);
                    $table_graph = Useful::set_table_one_sum_json($remain_graph);    
                }
                $remain_table = $Remain->getRemainTable($data['date_from'], $data['date_to']);
                $table_table = Useful::set_table_remain_json($remain_table);
                
                /*echo "<pre>";
                    print_r($remain_table); 
                    print_r($table_table);
                    echo "</pre>";*/
                
                 
            } else {
                $errors = $validate->errors('validation');        
            }
            echo $json_graph = json_encode(array("data" => $table_graph, "data1" => $name, "data2" => $table_table, "data3" => implode(", ", $errors)));
        } else {
            throw new HTTP_Exception_404('Сторінка не знайдена');
            return;    
        }
    }
    
    public function action_sale() {
        $Useful = new Model_Useful();
        $Storecity = new Model_Storecity();
        $CompanyIdentifier = new Model_CompanyIdentifier();
        $Sale = new Model_Sale();
        $data = Arr::extract($_POST, array('date_from', 'date_to', 'store_city_id', 'company_id', 'store_city_sum', 'company_sum', 'button'));
        $data = Security::xss_clean($data);
        $errors = array();
        if (!empty($data['button'])) {
            /*$data['store_city_id'] = 'FB728993-C2D2-4DDF-A554-FEFF595A37E2,D0828A65-3967-4F9C-B8FD-3F93D8047347,2052FF30-31C8-4DE0-AA02-CB62D209807D,EDB412EC-A4AA-44D4-BE40-A4B5C0418C8C,5C901735-D844-48E8-BF9B-E616DFBFAC26,5A110628-F072-4D70-9F4E-D40DC34FAF49,AD9F65C9-E18B-47AB-9DA7-F18F0245D1F7,A6A000EC-E550-4945-ADB5-3CC5F533E714,43104D06-BFC8-416C-9DEF-25CC4EE32E05,6F2E0E40-CD44-41CB-B7D5-0503B6A1E027,57D7D509-6CC4-426F-90AB-494FC0455371,810CF7FB-73BB-49E3-A923-E37E8FB27423,C87F62DF-3A1E-434F-9AFD-E30406A0792E,7DB90974-CF77-4436-90E2-1688502E77FB,C49EB139-1FA9-4260-B783-793FA67EE9A6,08C648FE-F77A-43A5-BDDC-4C2F3CAB2A8B,0BCCDD75-EAC7-40CC-8851-3F2FD89B7DFB';
            $data['company_id'] = '{C82D25C0-D7A3-4FE7-AECA-6E5914A09EDC}';
            $data['company_sum'] = 'false';
            $data['store_city_sum'] = 'true';
            $data['date_from'] = '2014-06-02';
            $data['date_to'] = '2014-06-08';*/
            
            $name = null;
            $table_graph = null;
            $table_table = null;
            $validate = Validation::factory($data)
                ->rules('date_from', array(array('not_empty'), array('date')))
                ->rules('date_to', array(array('not_empty'), array('date')))
                ->rules('store_city_id', array(array('not_empty')))
                ->rules('company_id', array(array('not_empty')))
            
                ->labels(array(
                    'date_from' => 'Дата з',
                    'date_to' => 'Дата по',
                    'store_city_id' => 'Department',
                    'company_id' => 'Ідентифікатор',
                    ));
            if ($validate->check()) {
                if ($data['store_city_sum'] == 'true' && $data['company_sum'] == 'true') {
                    $name1 = implode(", ", $Storecity->getStoreCityName($data['store_city_id']));
                    $name2 = implode(", ", $CompanyIdentifier->getCompanyIdentifierName(explode(",", $data['company_id'])));
                    $name = "<p><strong><span><u>Department</u></span></strong>: <strong>Σ</strong> ($name1)</p>
                    <p><strong><span><u>Entrepreneur</u></span></strong>: <strong>Σ</strong> ($name2)</p>";
                    $sale_graph = $Sale->getSaleGraph($data['date_from'], $data['date_to'], null, null, 1);
                    $table_graph = Useful::set_table_sale_sum_json($sale_graph);
                } elseif (($data['store_city_sum'] == 'true' || (count(explode(",", $data['store_city_id'])) == 1)) && $data['company_sum'] == 'false') {
                    $data['store_city_sum'] == 'true' ? $sum1 = '<strong>Σ</strong>' : $sum1 = '';
                    $data['company_sum'] == 'true' ? $sum2 = '<strong>Σ</strong>' : $sum2 = '';
                    $name1 = implode(", ", $Storecity->getStoreCityName($data['store_city_id']));
                    $name2 = implode(", ", $CompanyIdentifier->getCompanyIdentifierName(explode(",", $data['company_id'])));
                    $name = "<p><strong><span><u>Department</u></span></strong>: $sum1 ($name1)</p>
                    <p><strong><span><u>Entrepreneur</u></span></strong>: $sum2 ($name2)</p>";
                    $sale_graph = $Sale->getSaleGraph($data['date_from'], $data['date_to'], $data['store_city_id'], $data['company_id'], 2);
                    $table_graph = Useful::set_table_one_sum_json($sale_graph);    
                } elseif (($data['company_sum'] == 'true' || (count(explode(",", $data['company_id'])) == 1)) && $data['store_city_sum'] == 'false') {
                    $data['store_city_sum'] == 'true' ? $sum1 = '<strong>Σ</strong>' : $sum1 = '';
                    $data['company_sum'] == 'true' ? $sum2 = '<strong>Σ</strong>' : $sum2 = '';
                    $name1 = implode(", ", $Storecity->getStoreCityName($data['store_city_id']));
                    $name2 = implode(", ", $CompanyIdentifier->getCompanyIdentifierName(explode(",", $data['company_id'])));
                    $name = "<p><strong><span><u>Department</u></span></strong>: $sum1 ($name1)</p>
                    <p><strong><span><u>Entrepreneur</u></span></strong>: $sum2 ($name2)</p>";
                    $sale_graph = $Sale->getSaleGraph($data['date_from'], $data['date_to'], $data['store_city_id'], $data['company_id'], 3);
                    $table_graph = Useful::set_table_one_sum_json($sale_graph);    
                }
                $sale_table = $Sale->getSaleTable($data['date_from'], $data['date_to']);
                $table_table = Useful::set_table_sale_json($sale_table);
                /*echo "<pre>";
                    print_r($sale_graph); 
                    print_r($table_graph);
                    echo "</pre>"; */
                 
            } else {
                $errors = $validate->errors('validation');        
            }
            echo $json_graph = json_encode(array("data" => $table_graph, "data1" => $name, "data2" => $table_table, "data3" => implode(", ", $errors)));
        } else {
            throw new HTTP_Exception_404('Сторінка не знайдена');
            return;    
        }
    }
    
    public function action_money() {
        $Useful = new Model_Useful();
        $CompanyIdentifier = new Model_CompanyIdentifier();
        $Money = new Model_Money();
        $data = Arr::extract($_POST, array('date_from', 'date_to', 'company_id', 'company_sum', 'button'));
        $data = Security::xss_clean($data);
        $errors = array();
        if (!empty($data['button'])) {
            /*$data['company_id'] = '{C82D25C0-D7A3-4FE7-AECA-6E5914A09EDC},{D626F76A-ED07-4D7F-8285-72DA96BE64CC},{56B11D0B-C419-4D1B-AF8F-B927043BBA57},{1A7EAFF0-7FCE-4CBF-AB91-B58EDA619A41}';
            $data['company_sum'] = 'true';
            $data['date_from'] = '2014-06-02';
            $data['date_to'] = '2014-06-08';*/
            
            $name = null;
            $table_graph = null;
            $table_table = null;
            $validate = Validation::factory($data)
                ->rules('date_from', array(array('not_empty'), array('date')))
                ->rules('date_to', array(array('not_empty'), array('date')))
                ->rules('company_id', array(array('not_empty')))
            
                ->labels(array(
                    'date_from' => 'Дата з',
                    'date_to' => 'Дата по',
                    'company_id' => 'Entrepreneur',
                    ));
            if ($validate->check()) {
                if ($data['company_sum'] == 'true') {
                    $sum = '<strong>Σ</strong>';
                    $name1 = implode(", ", $CompanyIdentifier->getCompanyIdentifierName(explode(",", $data['company_id'])));
                    $name = "<p><strong><span><u>Entrepreneur</u></span></strong>: $sum ($name1)</p>";
                    $money_graph = $Money->getMoneyGraph($data['date_from'], $data['date_to'], null, 5);
                    $table_graph = Useful::set_table_money_sum_json($money_graph);
                } else {
                    $name1 = implode(", ", $CompanyIdentifier->getCompanyIdentifierName(explode(",", $data['company_id'])));
                    $name = "<p><strong><span><u>Entrepreneur</u></span></strong>: ($name1)</p>";
                    $money_graph = $Money->getMoneyGraph($data['date_from'], $data['date_to'], $data['company_id'], 4);
                    $table_graph = Useful::set_table_one_sum_json($money_graph);
                }
                $money_table = $Money->getMoneyTable($data['date_from'], $data['date_to']);
                $table_table = Useful::set_table_money_json($money_table);
                /*echo "<pre>";
                    print_r($table_table);
                    echo "</pre>";*/   
                 
            } else {
                $errors = $validate->errors('validation');        
            }
            echo $json_graph = json_encode(array("data" => $table_graph, "data1" => $name, "data2" => $table_table, "data3" => implode(", ", $errors)));
        } else {
            throw new HTTP_Exception_404('Сторінка не знайдена');
            return;    
        }    
    }
    
    public function action_costs() {
        $Useful = new Model_Useful();
        $Storecity = new Model_Storecity();
        $Pocket = new Model_Pocket();
        $Costs = new Model_Costs();
        $data = Arr::extract($_POST, array('date_from', 'date_to', 'store_city_id', 'company_id', 'store_city_sum', 'company_sum', 'button'));
        $data = Security::xss_clean($data);
        $errors = array();
        if (!empty($data['button'])) {
            /*$data['store_city_id'] = '57D7D509-6CC4-426F-90AB-494FC0455371';
            $data['company_id'] = '{55637DD9-FC36-46AA-A21C-748AE0AF282A}';
            $data['company_sum'] = 'true';
            $data['store_city_sum'] = 'true';
            $data['date_from'] = '2014-06-02';
            $data['date_to'] = '2014-06-08';*/
            
            $name = null;
            $table_graph = null;
            $table_table = null;
            $validate = Validation::factory($data)
                ->rules('date_from', array(array('not_empty'), array('date')))
                ->rules('date_to', array(array('not_empty'), array('date')))
                ->rules('store_city_id', array(array('not_empty')))
                ->rules('company_id', array(array('not_empty')))
            
                ->labels(array(
                    'date_from' => 'Дата з',
                    'date_to' => 'Дата по',
                    'store_city_id' => 'Department',
                    'company_id' => 'Pocket',
                    ));
            if ($validate->check()) {
                if ($data['store_city_sum'] == 'true' && $data['company_sum'] == 'true') {
                    $name1 = implode(", ", $Storecity->getStoreCityName($data['store_city_id']));
                    $name2 = implode(", ", $Pocket->getPocketName($data['company_id']));
                    $name = "<p><strong><span><u>Department</u></span></strong>: <strong>Σ</strong> ($name1)</p>
                    <p><strong><span><u>Pocket</u></span></strong>: <strong>Σ</strong> ($name2)</p>";
                    $costs_graph = $Costs->getCostsGraph($data['date_from'], $data['date_to'], null, null, 6);
                    $table_graph = Useful::set_table_costs_sum_json($costs_graph);
                } elseif (($data['store_city_sum'] == 'true' || (count(explode(",", $data['store_city_id'])) == 1)) && $data['company_sum'] == 'false') {
                    $data['store_city_sum'] == 'true' ? $sum1 = '<strong>Σ</strong>' : $sum1 = '';
                    $data['company_sum'] == 'true' ? $sum2 = '<strong>Σ</strong>' : $sum2 = '';
                    $name1 = implode(", ", $Storecity->getStoreCityName($data['store_city_id']));
                    $name2 = implode(", ", $Pocket->getPocketName($data['company_id']));
                    $name = "<p><strong><span><u>Department</u></span></strong>: $sum1 ($name1)</p>
                    <p><strong><span><u>Pocket</u></span></strong>: $sum2 ($name2)</p>";
                    $costs_graph = $Costs->getCostsGraph($data['date_from'], $data['date_to'], $data['store_city_id'], $data['company_id'], 8);
                    $table_graph = Useful::set_table_one_sum_json($costs_graph);
                } elseif (($data['company_sum'] == 'true' || (count(explode(",", $data['company_id'])) == 1)) && $data['store_city_sum'] == 'false') {
                    $data['store_city_sum'] == 'true' ? $sum1 = '<strong>Σ</strong>' : $sum1 = '';
                    $data['company_sum'] == 'true' ? $sum2 = '<strong>Σ</strong>' : $sum2 = '';
                    $name1 = implode(", ", $Storecity->getStoreCityName($data['store_city_id']));
                    $name2 = implode(", ", $Pocket->getPocketName($data['company_id']));
                    $name = "<p><strong><span><u>Department</u></span></strong>: $sum1 ($name1)</p>
                    <p><strong><span><u>Pocket</u></span></strong>: $sum2 ($name2)</p>";
                    $costs_graph = $Costs->getCostsGraph($data['date_from'], $data['date_to'], $data['store_city_id'], $data['company_id'], 7);
                    $table_graph = Useful::set_table_one_sum_json($costs_graph);
                }
                $costs_table = $Costs->getCostsTable($data['date_from'], $data['date_to']);
                $table_table = Useful::set_table_costs_json($costs_table);
                /*echo "<pre>";
                print_r($costs_table);
                echo "</pre>";*/
                 
            } else {
                $errors = $validate->errors('validation');        
            }
            echo $json_graph = json_encode(array("data" => $table_graph, "data1" => $name, "data2" => $table_table, "data3" => implode(", ", $errors), "data2_count" => count($costs_table)));
        } else {
            throw new HTTP_Exception_404('Сторінка не знайдена');
            return;    
        }
    }
}
<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Ad
 *
 * @property int $id ID
 * @property int $uid 用户ID
 * @property string|null $title 标题
 * @property string $type 类型
 * @property array|null $data 内容
 * @property int $clicks 点击数
 * @property int $available 是否可用
 * @property \Illuminate\Support\Carbon|null $begin_at 生效日期
 * @property \Illuminate\Support\Carbon|null $end_at 失效日期
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read array|string|null $state_des
 * @property-read mixed|null $type_des
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereBeginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ad whereUpdatedAt($value)
 */
	class Ad extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Block
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BlockItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Block newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Block newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Block query()
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Block whereName($value)
 */
	class Block extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BlockItem
 *
 * @property int $id 主键
 * @property int $block_id 块ID
 * @property string|null $title 标题
 * @property string|null $description 副标题
 * @property string $image 图片
 * @property string|null $url 链接
 * @property string|null $field_1
 * @property string|null $field_2
 * @property string|null $field_3
 * @property int|null $sort_num 显示顺序
 * @property-read \App\Models\Block|null $block
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereBlockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereField1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereField2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereField3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockItem whereUrl($value)
 */
	class BlockItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cart
 *
 * @property int $id 主键
 * @property string $user_id 用户ID
 * @property int $shop_id 店铺ID
 * @property int $product_id 产品ID
 * @property string|null $title 产品标题
 * @property string $image 大图
 * @property int $quantity 产品数量
 * @property string $price 商品价格
 * @property int $sku_id SKU ID
 * @property string|null $sku_title SKU名称
 * @property array|null $meta_data 附加选项
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Shop|null $shop
 * @property-read \App\Models\ProductSku|null $sku
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSkuTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUserId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id 分类ID
 * @property int $parent_id 父级分类
 * @property string|null $name 分类名称
 * @property string|null $slug 别名
 * @property string $image 图标
 * @property string|null $description 描述
 * @property string|null $taxonomy 分类法
 * @property int|null $sort_num 排序
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $childs
 * @property-read int|null $childs_count
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read mixed $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CategoryMeta> $metas
 * @property-read int|null $metas_count
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $siblings
 * @property-read int|null $siblings_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTaxonomy($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CategoryMeta
 *
 * @property int $meta_id
 * @property int $category_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereMetaValue($value)
 */
	class CategoryMeta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Coupon
 *
 * @property int $id 主键
 * @property string|null $title 名称
 * @property int $type 类别
 * @property string $value 面值
 * @property string $min_amount 最小使用金额
 * @property int $per_limit 每人限领
 * @property \Illuminate\Support\Carbon|null $start_at 生效时间
 * @property \Illuminate\Support\Carbon|null $end_at 失效时间
 * @property int $used_count 已使用量
 * @property int $shop_id 关联店铺
 * @property int $state 是否可用
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property-read mixed $description
 * @property-read mixed $state_des
 * @property-read mixed $validity_range
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereMinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon wherePerLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUsedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereValue($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Deliveryer
 *
 * @property int $id 主键
 * @property string|null $name 配送员姓名
 * @property string|null $phone 配送员电话
 * @property string $image 照片
 * @property float $lng 当前位置
 * @property float $lat 当前位置
 * @property string|null $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereUpdatedAt($value)
 */
	class Deliveryer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @property int $id ID
 * @property int $parent_id 父级ID
 * @property string|null $name 全称
 * @property string|null $short_name 名称
 * @property int $level 级别
 * @property float|null $lng 经度
 * @property float|null $lat 纬度
 * @property string|null $pinyin 拼音
 * @property string|null $letter 首字母
 * @property string|null $zonecode 区位代码
 * @property string|null $citycode 区号
 * @property string|null $zipcode 邮编
 * @property int $sort_num 排序
 * @property-read \Illuminate\Database\Eloquent\Collection<int, District> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, District> $childs
 * @property-read int|null $childs_count
 * @property-read District|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCitycode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District wherePinyin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereZipcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereZonecode($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Express
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 * @property string|null $regular
 * @property int $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|Express newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Express newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Express query()
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereRegular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Express whereSortNum($value)
 */
	class Express extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feedback
 *
 * @property int $id 主键
 * @property int $user_id 管理用户
 * @property string|null $title 标题
 * @property string|null $message 内容
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUserId($value)
 */
	class Feedback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FreightTemplate
 *
 * @property int $id 模板ID
 * @property int $shop_id 店铺ID
 * @property string|null $template_name 模板名称
 * @property string|null $template_info 描述
 * @property int $valuation 计价方式
 * @property int $start_quantity 默认数量
 * @property string $start_fee 默认运费
 * @property int $growth_quantity 递增数量
 * @property string $growth_fee 递增运费
 * @property string|null $delivery_areas 配送区域
 * @property string $free_amount 包邮金额
 * @property int $free_quantity 包邮数量
 * @property-read \App\Models\Shop|null $shop
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereDeliveryAreas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereFreeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereFreeQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereGrowthFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereGrowthQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereStartFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereStartQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereTemplateInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereTemplateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereValuation($value)
 */
	class FreightTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JPush
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $client_id
 * @property string|null $os
 * @property string|null $registerid
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|JPush android()
 * @method static \Illuminate\Database\Eloquent\Builder|JPush ios()
 * @method static \Illuminate\Database\Eloquent\Builder|JPush newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JPush newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JPush query()
 * @method static \Illuminate\Database\Eloquent\Builder|JPush whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JPush whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JPush whereOs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JPush whereRegisterid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JPush whereUserId($value)
 */
	class JPush extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Kefu
 *
 * @property int $id 主键
 * @property string|null $title 标题
 * @property string|null $phone 电话
 * @property string|null $weixin 微信
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|Kefu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kefu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kefu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kefu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kefu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kefu wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kefu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kefu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kefu whereWeixin($value)
 */
	class Kefu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Link
 *
 * @property int $id 主键
 * @property int $category_id 分类ID
 * @property string $type 类型
 * @property string|null $title 标题
 * @property string|null $url 链接
 * @property string $image 图片
 * @property string|null $description 描述
 * @property int $sort_num 排序
 * @property-read Link|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Link> $links
 * @property-read int|null $links_count
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link onlyCategory()
 * @method static \Illuminate\Database\Eloquent\Builder|Link onlyLink()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUrl($value)
 */
	class Link extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Material
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $description
 * @property string $src
 * @property string $thumb
 * @property string|null $width
 * @property string|null $height
 * @property string|null $type
 * @property string|null $extension 扩展名
 * @property int $size
 * @property string|null $mime
 * @property int $views
 * @property int $downloads
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|string $formated_size
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Material filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Material newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Material newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Material paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Material query()
 * @method static \Illuminate\Database\Eloquent\Builder|Material simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereDownloads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Material whereWidth($value)
 */
	class Material extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Menu
 *
 * @property int $id 主键
 * @property string|null $name 名称
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MenuItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MenuItem> $visibleItems
 * @property-read int|null $visible_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereName($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MenuItem
 *
 * @property int $id 主键
 * @property int $menu_id 菜单ID
 * @property int $parent_id 父级ID
 * @property string|null $title 名称
 * @property string|null $url 链接
 * @property string $image 图片
 * @property string $target 目标
 * @property int $hide 是否隐藏
 * @property int $sort_num 显示序号
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MenuItem> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Menu|null $menu
 * @property-read MenuItem|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItem whereUrl($value)
 */
	class MenuItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Notification
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $notifiable
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseNotification read()
 * @method static \Illuminate\Database\Eloquent\Builder|DatabaseNotification unread()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $order_id 主键
 * @property string|null $order_no 订单编号
 * @property int $order_type 订单类型,1=普通订单,2=拼单,3=超市订单,4=外卖订单
 * @property int $shop_id 门店ID
 * @property string|null $shop_name 门店名称
 * @property int $buyer_id 买家ID
 * @property string|null $buyer_name 买家账号
 * @property string|null $buyer_note 买家留言
 * @property int $seller_id 卖家ID
 * @property string|null $seller_name 卖家账号
 * @property string $discount_total 优惠金额
 * @property string $discount_tax 优惠税额
 * @property string $total
 * @property string $total_tax
 * @property int $prices_include_tax
 * @property string $payment_method
 * @property string|null $payment_method_title
 * @property int $payment_status 支付状态，1=已支付，0=未支付
 * @property \Illuminate\Support\Carbon|null $payment_at 付款时间
 * @property int $shipping_method 配送方式
 * @property string $shipping_total 配送费
 * @property string $shipping_tax
 * @property int $shipping_status 发货状态，0=未发货，1=已发货
 * @property \Illuminate\Support\Carbon|null $shipping_at 发货时间
 * @property int $buyer_rate 买家评价状态，0=未评价，1=已评价
 * @property int $seller_rate 卖家评价状态，0=未评价，1=已评价
 * @property int $buyer_deleted 买家已删除
 * @property int $seller_deleted 卖家已删除
 * @property string|null $out_trade_no 第三方支付订单号
 * @property array|null $fee_lines 费用列表
 * @property array|null $discount_lines 优惠列表
 * @property array|null $shipping 配送地址
 * @property array|null $billing 账单地址
 * @property string $status 订单状态
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\User|null $buyer
 * @property-read array|\Illuminate\Contracts\Translation\Translator|string|null $pay_status_des
 * @property-read mixed|null $status_des
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderNote> $notes
 * @property-read int|null $notes_count
 * @property-read \App\Models\User|null $seller
 * @property-read \App\Models\Shop|null $shop
 * @property-read \App\Models\UserTransaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|Order filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBilling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBuyerDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBuyerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBuyerNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBuyerRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountLines($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFeeLines($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOutTradeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethodTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePricesIncludeTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSellerDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSellerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSellerRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShopName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderItem
 *
 * @property int $trade_id 主键
 * @property int $order_id 订单ID
 * @property int $product_id 商品ID
 * @property string|null $title 商品名称
 * @property string $price 商品价格
 * @property int $quantity 商品数量
 * @property string $image 商品图片
 * @property array|null $meta_data
 * @property int|null $sku_id 属性ID
 * @property string|null $sku_title 商品属性
 * @property int $is_gift 是否赠品
 * @property string $status 交易状态
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Refund|null $refund
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereIsGift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereSkuTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTradeId($value)
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderNote
 *
 * @property int $id
 * @property int $order_id 订单ID
 * @property int $user_id 操作用户ID
 * @property string|null $content 操作内容
 * @property \Illuminate\Support\Carbon|null $created_at 操作时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereUserId($value)
 */
	class OrderNote extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id 页面ID
 * @property int|null $user_id 作者ID
 * @property string|null $title 标题
 * @property string|null $slug 别名
 * @property string $image 图片
 * @property string|null $keywords
 * @property string|null $description 摘要
 * @property string|null $content 内容
 * @property int $sort_num 显示顺序
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \Illuminate\Contracts\Routing\UrlGenerator|string $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PageMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUserId($value)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PageMeta
 *
 * @property int $meta_id
 * @property int $page_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|PageMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageMeta wherePageId($value)
 */
	class PageMeta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PhotoWall
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $thumb
 * @property string|null $image
 * @property int|null $sort_num
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Support\Collection $meta_data
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhotoWall whereUpdatedAt($value)
 */
	class PhotoWall extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id 文章ID
 * @property int $user_id 会员ID
 * @property string|null $author 作者
 * @property string|null $format 文章格式
 * @property string|null $type 文章类型
 * @property string|null $title 文章标题
 * @property string|null $slug 别名
 * @property string|null $keywords 标签
 * @property string|null $description 摘要
 * @property string $image 图片
 * @property int $allow_comment 允许评论
 * @property int $comment_num 评论数
 * @property int $collect_num 被收藏数
 * @property int $like_num 点赞数
 * @property int $views 浏览数
 * @property string|null $from 来源
 * @property string|null $fromurl 来源地址
 * @property float $price 阅读价格
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $collectedUsers
 * @property-read int|null $collected_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostComment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\PostContent|null $content
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read mixed $status_des
 * @property-read \Illuminate\Contracts\Routing\UrlGenerator|string $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostLog> $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Post filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAllowComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCollectNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCommentNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFromurl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLikeNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereViews($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostComment
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string|null $username
 * @property int $reply_uid
 * @property string|null $reply_name
 * @property string|null $message
 * @property string|null $province
 * @property string|null $city
 * @property string|null $street
 * @property int $likes
 * @property int $state 审核状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post|null $post
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereReplyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereReplyUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostComment whereUsername($value)
 */
	class PostComment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostContent
 *
 * @property int $post_id
 * @property string|null $content
 * @property-read \App\Models\Post|null $post
 * @method static \Illuminate\Database\Eloquent\Builder|PostContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostContent wherePostId($value)
 */
	class PostContent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostImage
 *
 * @property int $id
 * @property int $post_id
 * @property string $thumb
 * @property string $image
 * @property int $isremote
 * @property string|null $description
 * @property int $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereIsremote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereThumb($value)
 */
	class PostImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostLog
 *
 * @property int $id 主键
 * @property int $post_id 文章ID
 * @property int $user_id 用户ID
 * @property string|null $content 内容
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PostLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLog wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostLog whereUserId($value)
 */
	class PostLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostMeta
 *
 * @property int $meta_id
 * @property int $post_id
 * @property string $meta_key
 * @property mixed $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta wherePostId($value)
 */
	class PostMeta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostTag
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PostTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostTag query()
 */
	class PostTag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id 商品ID
 * @property int $user_id 用户ID
 * @property int $shop_id 门店ID
 * @property string|null $title 宝贝标题
 * @property string|null $slug 宝贝Slug
 * @property string $image 特色图片
 * @property string|null $price 一口价
 * @property string|null $regular_price 正常价
 * @property int $purchase_limit 限购数量
 * @property int $sold 销量
 * @property int $stock 库存
 * @property int $views 浏览量
 * @property int $collect_num 收藏数量
 * @property int $comment_num 评论数
 * @property array|null $attr_list 产品属性
 * @property array|null $variation_list 产品变量
 * @property array|null $additional_options 可选项目
 * @property int $is_new 是否新品
 * @property int $is_hot 是否热销
 * @property int $is_recommend 仓储推荐
 * @property int $is_promotion 是否促销
 * @property int $is_top 是否置顶
 * @property int $free_delivery 免运费
 * @property int $template_id 运费模板
 * @property int $is_weight_template 是否按重量计价
 * @property int $has_sku_attr 是否有多级型号
 * @property int $brand_id 品牌
 * @property string $status 商品状态
 * @property string|null $tax_status 含税状态
 * @property string|null $keywords 关键词
 * @property string|null $description 简短描述
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $collectedUsers
 * @property-read int|null $collected_users_count
 * @property-read \App\Models\ProductContent|null $content
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read array|string|null $status_des
 * @property-read \Illuminate\Contracts\Routing\UrlGenerator|string $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductGroup> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Shop|null $shop
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSku> $skus
 * @property-read int|null $skus_count
 * @property-read \App\Models\FreightTemplate|null $template
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Product filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAdditionalOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAttrList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCollectNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCommentNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFreeDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasSkuAttr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsHot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsPromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsWeightTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePurchaseLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRegularPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTaxStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVariationList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereViews($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductAttributeOption
 *
 * @property int $id
 * @property int $attr_id
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption whereAttrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption whereValue($value)
 */
	class ProductAttributeOption extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductContent
 *
 * @property int $product_id 产品ID
 * @property string|null $content 产品详情
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent whereProductId($value)
 */
	class ProductContent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductGroup
 *
 * @property int $id 主键
 * @property int $user_id 团长ID
 * @property int $product_id 产品ID
 * @property int $required_num 需求人数
 * @property string $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductGroupItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereRequiredNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereUserId($value)
 */
	class ProductGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductGroupItem
 *
 * @property int $id 主键
 * @property int $group_id 团ID
 * @property int $user_id 用户ID
 * @property int|null $product_id 产品ID
 * @property int|null $order_id 订单ID
 * @property int $is_chief 是否团长
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property-read \App\Models\ProductGroup|null $group
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem whereIsChief($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroupItem whereUserId($value)
 */
	class ProductGroupItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductImage
 *
 * @property int $id 主键
 * @property int $product_id 产品
 * @property string $thumb 小图
 * @property string $image 大图
 * @property int $sort_num 显示顺序
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereThumb($value)
 */
	class ProductImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductMeta
 *
 * @property int $meta_id
 * @property int $product_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta whereProductId($value)
 */
	class ProductMeta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductReview
 *
 * @property int $id 主键
 * @property int $user_id 用户
 * @property int $order_id 关联订单
 * @property int $product_id 关联商品
 * @property string|null $message 评论内容
 * @property int $product_scores 商品评分
 * @property int $service_scores 服务评分
 * @property int $logistics_scores 物流评分
 * @property int $anony 匿名评论
 * @property \Illuminate\Support\Carbon|null $created_at 评论时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductReviewImage> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereAnony($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereLogisticsScores($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereProductScores($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereServiceScores($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereUserId($value)
 */
	class ProductReview extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductReviewImage
 *
 * @property int $id
 * @property int $review_id
 * @property string $thumb
 * @property string $image
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewImage whereReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReviewImage whereThumb($value)
 */
	class ProductReviewImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductSku
 *
 * @property int $id SKU ID
 * @property int $product_id 商品ID
 * @property string|null $title SKU名称
 * @property string|null $image 图片
 * @property string $price 价格
 * @property int $stock 库存
 * @property string|null $code SKU编码
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereTitle($value)
 */
	class ProductSku extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductVariation
 *
 * @property int $id
 * @property string|null $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductVariationOption> $options
 * @property-read int|null $options_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereName($value)
 */
	class ProductVariation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductVariationOption
 *
 * @property int $id
 * @property int $var_id
 * @property string|null $title
 * @property string $price
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption whereVarId($value)
 */
	class ProductVariationOption extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Refund
 *
 * @property int $refund_id 主键
 * @property int $order_id 订单ID
 * @property int $trade_id 子订单ID
 * @property int $uid 用户ID
 * @property string|null $refund_no 退款单号
 * @property int $refund_type 退货类型,1=仅退款,2=退货退款
 * @property string $refund_amount 退款金额
 * @property string|null $refund_reason 退货原因
 * @property string|null $refund_desc 退款说明
 * @property string|null $refund_remark 备注
 * @property int $refund_state 处理状态
 * @property int $goods_state 货物状态
 * @property int|null $shipping_state 退货状态
 * @property \Illuminate\Support\Carbon|null $shipping_at 退货时间
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null $goods_state_des
 * @property-read array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null $refund_state_des
 * @property-read array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null $refund_type_des
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RefundImage> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\RefundShipping|null $shipping
 * @property-read \App\Models\OrderItem|null $trade
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Refund filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Refund newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Refund paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund query()
 * @method static \Illuminate\Database\Eloquent\Builder|Refund simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereGoodsState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereRefundAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereRefundDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereRefundId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereRefundNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereRefundReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereRefundRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereRefundState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereRefundType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereShippingAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereShippingState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Refund whereUpdatedAt($value)
 */
	class Refund extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RefundAddress
 *
 * @property int $id 主键
 * @property int $uid 用户ID
 * @property string|null $name 姓名
 * @property string|null $phone 电话
 * @property string|null $province 省
 * @property string|null $city 市
 * @property string|null $district 区县
 * @property string|null $street 街道
 * @property string|null $postalcode 邮编
 * @property int $isdefault 是否默认
 * @property-read string $formatted_address
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress whereIsdefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress wherePostalcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundAddress whereUid($value)
 */
	class RefundAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RefundImage
 *
 * @property int $id
 * @property int $refund_id
 * @property string $thumb
 * @property string $image
 * @method static \Illuminate\Database\Eloquent\Builder|RefundImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundImage whereRefundId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundImage whereThumb($value)
 */
	class RefundImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RefundShipping
 *
 * @property int $id 主键
 * @property int $refund_id 订单ID
 * @property string|null $express_code 快递编码
 * @property string|null $express_name 快递名称
 * @property string|null $express_no 快递单号
 * @property string|null $name 联系人
 * @property string|null $phone 联系电话
 * @property string|null $province 省
 * @property string|null $city 市
 * @property string|null $county 县
 * @property string|null $street 街道
 * @property string|null $postalcode 邮编
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read string $formatted_address
 * @property-read \App\Models\Refund|null $refund
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping query()
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereExpressCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereExpressName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereExpressNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping wherePostalcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereRefundId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RefundShipping whereUpdatedAt($value)
 */
	class RefundShipping extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property string $skey 标识
 * @property string|null $svalue 值
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSkey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSvalue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShippingZone
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string $fee
 * @property int $enable
 * @property int $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingZone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingZone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingZone query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingZone whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingZone whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingZone whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingZone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingZone whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingZone whereTitle($value)
 */
	class ShippingZone extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shop
 *
 * @property int $id 店铺ID
 * @property int $user_id 店主UID
 * @property string|null $name 店铺名称
 * @property int $type 店铺类型，1=总店，2=分店
 * @property string $logo 店铺标志
 * @property string|null $country 国家
 * @property string|null $province 所在省
 * @property string|null $city 所在市
 * @property string|null $district 所在县
 * @property string|null $address_1 地址1
 * @property string|null $address_2 地址2
 * @property float|null $latitude 纬度
 * @property float|null $longitude 经度
 * @property int $views 浏览次数
 * @property int $subscribe_num 关注量
 * @property int $visitors 访客数
 * @property string $turnover 营业额
 * @property int $month_sales 月销量
 * @property int $cumulative_sales 累计销量
 * @property string|null $description 店铺简介
 * @property float|null $scores 评分
 * @property int $verify_status 认证状态
 * @property int $bond_status 缴纳保证金状态
 * @property string|null $last_reviews 最新评价
 * @property string|null $notice 店铺公告
 * @property int $is_seven_refund 7天无理由退货
 * @property int $is_pay_reduce_stock 付款减库存
 * @property int $is_refund_rollback_stock 退货恢复库存
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at 开店时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null $bond_status_des
 * @property-read string $formatted_address
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read string $status_des
 * @property-read array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null $verify_status_des
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShopImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShopMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $subscribedUsers
 * @property-read int|null $subscribed_users_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Shop filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereBondStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCumulativeSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereIsPayReduceStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereIsRefundRollbackStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereIsSevenRefund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLastReviews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereMonthSales($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereScores($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereSubscribeNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereTurnover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereVerifyStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereVisitors($value)
 */
	class Shop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopImage
 *
 * @property int $id 主键
 * @property int $shop_id 门店ID
 * @property string|null $thumb 小图
 * @property string $image 图片
 * @property int $sort_num 排序
 * @method static \Illuminate\Database\Eloquent\Builder|ShopImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopImage whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopImage whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopImage whereThumb($value)
 */
	class ShopImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopMeta
 *
 * @property int $meta_id
 * @property int $shop_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta whereShopId($value)
 */
	class ShopMeta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shortcut
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $content
 * @property int|null $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|Shortcut newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shortcut newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shortcut query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shortcut whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shortcut whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shortcut whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shortcut whereType($value)
 */
	class Shortcut extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Snippet
 *
 * @property int $id 主键
 * @property string|null $name 名称
 * @property string|null $content 内容
 * @property string|null $link 链接
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snippet whereUpdatedAt($value)
 */
	class Snippet extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id 主键
 * @property int $gid 管理权限
 * @property string|null $nickname 昵称
 * @property string|null $phone 手机号
 * @property string|null $email 邮箱
 * @property string|null $avatar 头像
 * @property string|null $password 密码
 * @property string|null $remember_token
 * @property int $freeze 冻结
 * @property int $email_status 邮箱验证状态
 * @property int $name_status 实名认证状态
 * @property int $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\UserAccount|null $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserAddress> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $boughts
 * @property-read int|null $boughts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cart> $carts
 * @property-read int|null $carts_count
 * @property-read \App\Models\UserCertify|null $certify
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $collectedPosts
 * @property-read int|null $collected_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserConnect> $connects
 * @property-read int|null $connects_count
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read array|string|null $status_des
 * @property-read \App\Models\UserGroup|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserLog> $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Material> $materials
 * @property-read int|null $materials_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $solds
 * @property-read int|null $solds_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserTransaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNameStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAccount
 *
 * @property int $id
 * @property int $user_id 会员ID
 * @property string|null $password 支付密码
 * @property string $balance 账户余额
 * @property string $freeze 冻结金额
 * @property string $total_income 累计收入
 * @property string $total_cost 累计支出
 * @property int $points 积分
 * @property int $coins 金币
 * @property int $freeze_coins 冻结金币
 * @property string $commission 佣金
 * @property string $cumulative_commission 累计佣金
 * @property string $withdrawal_commission 成功提现佣金
 * @property float $reward 奖励
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereCoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereCumulativeCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereFreezeCoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereTotalIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAccount whereWithdrawalCommission($value)
 */
	class UserAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAddress
 *
 * @property int $id 主键
 * @property int $user_id 用户ID
 * @property string|null $tag 标签
 * @property string|null $name 姓名
 * @property string|null $phone 电话
 * @property string|null $country
 * @property string|null $state 省
 * @property string|null $city 市
 * @property string|null $county 区县
 * @property string|null $address 详细地址
 * @property float $latitude 纬度
 * @property float $longitude 经度
 * @property string|null $postalcode 邮编
 * @property int $isdefault 是否默认地址
 * @property-read string $formatted_address
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereIsdefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress wherePostalcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereUserId($value)
 */
	class UserAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserCertify
 *
 * @property int $user_id 用户ID
 * @property string|null $fullname 姓名
 * @property string|null $id_card_no 身份证号
 * @property string|null $id_card_front 身份证正面
 * @property string|null $id_card_back 身份证背面
 * @property string|null $id_card_hand 手持身份证
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify whereIdCardBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify whereIdCardFront($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify whereIdCardHand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify whereIdCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCertify whereUserId($value)
 */
	class UserCertify extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserConnect
 *
 * @property int $id 主键
 * @property int $user_id 用户ID
 * @property string|null $appid APPID
 * @property string|null $platform 平台
 * @property string|null $openid 开放ID
 * @property string|null $unionid UnionID
 * @property string|null $nickname 昵称
 * @property int $gender 性别
 * @property string|null $city 城市
 * @property string|null $province 省，州
 * @property string|null $country 国籍
 * @property string|null $avatar 头像地址
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereAppid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereUnionid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserConnect whereUserId($value)
 */
	class UserConnect extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserCoupon
 *
 * @property int $id 主键
 * @property int|null $user_id 关联用户
 * @property int|null $coupon_id 关联优惠券
 * @property string|null $code 优惠券编码
 * @property int $used 是否已使用
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereUserId($value)
 */
	class UserCoupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserGroup
 *
 * @property int $gid 主键
 * @property string|null $name 名称
 * @property int $credits 积分下限
 * @property string|null $memo 备注
 * @property array|null $privileges 权限
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserGroup whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserGroup whereGid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserGroup whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserGroup wherePrivileges($value)
 */
	class UserGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserLog
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $ip
 * @property string|null $operate
 * @property string|null $address
 * @property string|null $src
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereOperate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLog whereUserId($value)
 */
	class UserLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserMeta
 *
 * @property int $meta_id
 * @property int $user_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMeta whereUserId($value)
 */
	class UserMeta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserPrepay
 *
 * @property int $id 主键
 * @property int $user_id 付款人ID
 * @property int $payable_id 关联类型ID
 * @property string $out_trade_no 单号
 * @property string|null $payment_id 付款ID
 * @property string|null $payment_type 付款方式
 * @property array|null $data 支付数据
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay whereOutTradeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay whereUserId($value)
 */
	class UserPrepay extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserTransaction
 *
 * @property int $id 主键
 * @property int $user_id 用户ID
 * @property int $type 交易类型:1=收入,2=支出
 * @property int $account_type 财务类型
 * @property string|null $out_trade_no 交易流水
 * @property string|null $pay_type 支付方式
 * @property int $pay_state 支付状态,0=未支付，1=已支付
 * @property \Illuminate\Support\Carbon|null $pay_at 付款时间
 * @property string|null $detail 交易说明
 * @property string $amount 交易金额
 * @property string|null $memo 交易备注
 * @property array|null $data 付款信息
 * @property int $other_account_id 对方账户ID
 * @property string|null $other_account_name 对方账户名称
 * @property \Illuminate\Support\Carbon|null $created_at 交易时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read mixed|null $pay_state_des
 * @property-read mixed|null $pay_type_des
 * @property-read mixed|null $type_des
 * @property-read \App\Models\User|null $otherAccount
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereOtherAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereOtherAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereOutTradeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction wherePayAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction wherePayState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereUserId($value)
 */
	class UserTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserVerify
 *
 * @property int $id
 * @property string|null $code 验证码
 * @property string|null $phone 手机号
 * @property string|null $email 邮箱
 * @property int $used 已使用
 * @property \Illuminate\Support\Carbon|null $created_at 发送时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha query()
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereUsed($value)
 */
	class UserVerify extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WechatLogin
 *
 * @property int $id 主键
 * @property int $uid 用户ID
 * @property string|null $basestr 秘钥
 * @property string|null $openid openid
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|WechatLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WechatLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WechatLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder|WechatLogin whereBasestr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatLogin whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatLogin whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatLogin whereUpdatedAt($value)
 */
	class WechatLogin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WechatMenu
 *
 * @property int $id 主键
 * @property int $parent_id 父级ID
 * @property string|null $name 菜单名称
 * @property string|null $type 菜单类型
 * @property string|null $key key
 * @property string|null $media_id 素材ID
 * @property string|null $url 跳转链接
 * @property string|null $appid 小程序appid
 * @property string|null $pagepath 小程序页面路径
 * @property int $sort_num 排序
 * @property-read \Illuminate\Database\Eloquent\Collection<int, WechatMenu> $children
 * @property-read int|null $children_count
 * @property-read array|\Illuminate\Contracts\Translation\Translator|string|null $type_des
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu whereAppid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu wherePagepath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatMenu whereUrl($value)
 */
	class WechatMenu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WechatSession
 *
 * @property int $id
 * @property string|null $openid
 * @property string|null $unionid
 * @property string|null $session_key
 * @method static \Illuminate\Database\Eloquent\Builder|WechatSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WechatSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WechatSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|WechatSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatSession whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatSession whereSessionKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WechatSession whereUnionid($value)
 */
	class WechatSession extends \Eloquent {}
}


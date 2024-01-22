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
 * @mixin \Eloquent
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
 * @mixin \Eloquent
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
 * @method static Builder|BlockItem newModelQuery()
 * @method static Builder|BlockItem newQuery()
 * @method static Builder|BlockItem query()
 * @method static Builder|BlockItem whereBlockId($value)
 * @method static Builder|BlockItem whereDescription($value)
 * @method static Builder|BlockItem whereField1($value)
 * @method static Builder|BlockItem whereField2($value)
 * @method static Builder|BlockItem whereField3($value)
 * @method static Builder|BlockItem whereId($value)
 * @method static Builder|BlockItem whereImage($value)
 * @method static Builder|BlockItem whereSortNum($value)
 * @method static Builder|BlockItem whereTitle($value)
 * @method static Builder|BlockItem whereUrl($value)
 * @mixin \Eloquent
 */
	class BlockItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumAssociation
 *
 * @property int $Id
 * @property string|null $Name
 * @property int|null $IsActive
 * @property int|null $Reserve
 * @property string|null $Description
 * @property string|null $YearBuilt
 * @property string|null $OperatingBankAccount
 * @property int|null $OperatingBankAccountId
 * @property array|null $AssociationManager
 * @property int|null $FiscalYearEndDay
 * @property int|null $FiscalYearEndMonth
 * @property array|null $TaxInformation
 * @property array|null $Address
 * @property string|null $Country
 * @property string|null $State
 * @property string|null $City
 * @property string|null $AddressLine1
 * @property string|null $AddressLine2
 * @property string|null $AddressLine3
 * @property string|null $PostalCode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $formatted_address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BuildiumAssociationUnit> $units
 * @property-read int|null $units_count
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereAddressLine3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereAssociationManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereFiscalYearEndDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereFiscalYearEndMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereOperatingBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereOperatingBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereReserve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereTaxInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociation whereYearBuilt($value)
 * @mixin \Eloquent
 */
	class BuildiumAssociation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumAssociationUnit
 *
 * @property int $Id
 * @property int $AssociationId
 * @property string|null $AssociationName
 * @property string|null $UnitNumber
 * @property string|null $UnitBedrooms
 * @property string|null $UnitBathrooms
 * @property int|null $UnitSize
 * @property array|null $Address
 * @property string|null $Country
 * @property string|null $State
 * @property string|null $City
 * @property string|null $AddressLine1
 * @property string|null $AddressLine2
 * @property string|null $AddressLine3
 * @property string|null $PostalCode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BuildiumAssociation|null $association
 * @property-read string $formatted_address
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereAddressLine3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereAssociationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereAssociationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereUnitBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereUnitBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereUnitNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereUnitSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumAssociationUnit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BuildiumAssociationUnit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumFile
 *
 * @property int $Id
 * @property int $EntityId
 * @property string|null $EntityType
 * @property string|null $Href
 * @property int $CategoryId
 * @property string|null $Title
 * @property string|null $Description
 * @property string|null $PhysicalFileName
 * @property int $Size
 * @property string|null $ContentType
 * @property string|null $UploadedDateTime
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereContentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereEntityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereHref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile wherePhysicalFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFile whereUploadedDateTime($value)
 * @mixin \Eloquent
 */
	class BuildiumFile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumFileCategory
 *
 * @property int $Id
 * @property string|null $Name
 * @property int $IsEditable
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFileCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFileCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFileCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFileCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFileCategory whereIsEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumFileCategory whereName($value)
 * @mixin \Eloquent
 */
	class BuildiumFileCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumForm
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $name
 * @property string|null $type
 * @property string|null $excerpt
 * @property string|null $attach
 * @property int|null $sort_num
 * @property int $category_id
 * @property string|null $entity_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BuildiumFileCategory|null $category
 * @property-read mixed $type_name
 * @property-read mixed $url
 * @method static Builder|BuildiumForm newModelQuery()
 * @method static Builder|BuildiumForm newQuery()
 * @method static Builder|BuildiumForm query()
 * @method static Builder|BuildiumForm whereAttach($value)
 * @method static Builder|BuildiumForm whereCategoryId($value)
 * @method static Builder|BuildiumForm whereCreatedAt($value)
 * @method static Builder|BuildiumForm whereEntityType($value)
 * @method static Builder|BuildiumForm whereExcerpt($value)
 * @method static Builder|BuildiumForm whereId($value)
 * @method static Builder|BuildiumForm whereName($value)
 * @method static Builder|BuildiumForm whereSortNum($value)
 * @method static Builder|BuildiumForm whereTitle($value)
 * @method static Builder|BuildiumForm whereType($value)
 * @method static Builder|BuildiumForm whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BuildiumForm extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumRental
 *
 * @property int $Id
 * @property string|null $Name
 * @property string|null $StructureDescription
 * @property string|null $NumberUnits
 * @property int|null $IsActive
 * @property int|null $OperatingBankAccountId
 * @property int|null $Reserve
 * @property string|null $YearBuilt
 * @property string|null $RentalType
 * @property string|null $RentalSubType
 * @property array|null $RentalManager
 * @property string|null $Address
 * @property string|null $Country
 * @property string|null $State
 * @property string|null $City
 * @property string|null $AddressLine1
 * @property string|null $AddressLine2
 * @property string|null $AddressLine3
 * @property string|null $PostalCode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $formatted_address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BuildiumRentalUnit> $units
 * @property-read int|null $units_count
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereAddressLine3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereNumberUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereOperatingBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereRentalManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereRentalSubType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereRentalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereReserve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereStructureDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRental whereYearBuilt($value)
 * @mixin \Eloquent
 */
	class BuildiumRental extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumRentalUnit
 *
 * @property int $Id
 * @property int $PropertyId
 * @property string|null $BuildingName
 * @property string|null $UnitNumber
 * @property string|null $Description
 * @property int|null $MarketRent
 * @property string|null $UnitBedrooms
 * @property string|null $UnitBathrooms
 * @property int|null $UnitSize
 * @property int $IsUnitListed
 * @property int $IsUnitOccupied
 * @property array|null $Address
 * @property string|null $Country
 * @property string|null $State
 * @property string|null $City
 * @property string|null $AddressLine1
 * @property string|null $AddressLine2
 * @property string|null $AddressLine3
 * @property string|null $PostalCode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $formatted_address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BuildiumRentalListing> $listings
 * @property-read int|null $listings_count
 * @property-read \App\Models\BuildiumRental|null $rental
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereAddressLine3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereBuildingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereIsUnitListed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereIsUnitOccupied($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereMarketRent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereUnitBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereUnitBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereUnitNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereUnitSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BuildiumRentalUnit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumRentalUnitImage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnitImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnitImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalUnitImage query()
 * @mixin \Eloquent
 */
	class BuildiumRentalUnitImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumRentalUnitListing
 *
 * @property int $Id
 * @property int $UnitId
 * @property int $PropertyId
 * @property \Illuminate\Support\Carbon|null $ListingDate
 * @property float|null $Rent
 * @property float|null $Deposit
 * @property string|null $LeaseTerms
 * @property \Illuminate\Support\Carbon|null $AvailableDate
 * @property int $IsManagedExternally
 * @property string|null $RentalApplicationUrl
 * @property array|null $Contact
 * @property array|null $Property
 * @property array|null $Unit
 * @property float $lng
 * @property float $lat
 * @property string|null $Country
 * @property string|null $State
 * @property string|null $City
 * @property string|null $AddressLine1
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $formatted_address
 * @property-read mixed $image
 * @property-read mixed $name
 * @property-read mixed $url
 * @property-read \App\Models\BuildiumRental|null $sProperty
 * @property-read \App\Models\BuildiumRentalUnit|null $sUnit
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereAvailableDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereIsManagedExternally($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereLeaseTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereListingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereRent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereRentalApplicationUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumRentalListing whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BuildiumRentalUnitListing extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumResource
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $type
 * @property string|null $attach
 * @property int|null $sort_num
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $type_name
 * @method static Builder|BuildiumResource newModelQuery()
 * @method static Builder|BuildiumResource newQuery()
 * @method static Builder|BuildiumResource query()
 * @method static Builder|BuildiumResource whereAttach($value)
 * @method static Builder|BuildiumResource whereCreatedAt($value)
 * @method static Builder|BuildiumResource whereId($value)
 * @method static Builder|BuildiumResource whereSortNum($value)
 * @method static Builder|BuildiumResource whereTitle($value)
 * @method static Builder|BuildiumResource whereType($value)
 * @method static Builder|BuildiumResource whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BuildiumResource extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumUploaded
 *
 * @property int $id
 * @property int $user_id
 * @property int $form_id
 * @property int $UnitId
 * @property int $CategoryId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BuildiumUploadedAttach> $attaches
 * @property-read int|null $attaches_count
 * @property-read \App\Models\BuildiumForm|null $form
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploaded whereUserId($value)
 * @mixin \Eloquent
 */
	class BuildiumUploaded extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BuildiumUploadedAttach
 *
 * @property int $id
 * @property int|null $uploaded_id
 * @property string|null $FileName
 * @property string|null $FileUrl
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploadedAttach newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploadedAttach newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploadedAttach query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploadedAttach whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploadedAttach whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploadedAttach whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploadedAttach whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploadedAttach whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildiumUploadedAttach whereUploadedId($value)
 * @mixin \Eloquent
 */
	class BuildiumUploadedAttach extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $cate_id 分类ID
 * @property int $parent_id 父级分类
 * @property string|null $name 分类名称
 * @property string|null $slug 别名
 * @property string $image 图标
 * @property string|null $description 描述
 * @property string|null $taxonomy 分类法
 * @property int|null $sort_num 排序
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $childs
 * @property-read int|null $childs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CategoryMeta> $metas
 * @property-read int|null $metas_count
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $siblings
 * @property-read int|null $siblings_count
 * @method static Builder|Category filter(array $input = [], $filter = null)
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Category query()
 * @method static Builder|Category simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|Category whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Category whereCateId($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Category whereImage($value)
 * @method static Builder|Category whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category whereSortNum($value)
 * @method static Builder|Category whereTaxonomy($value)
 * @mixin \Eloquent
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CategoryMeta
 *
 * @property int $meta_id
 * @property int $cate_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereCateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryMeta whereMetaValue($value)
 * @mixin \Eloquent
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
 * @mixin \Eloquent
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @property int $id ID
 * @property int $parent_id 父级ID
 * @property string|null $name 名称
 * @property string|null $fullname 全称
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
 * @method static Builder|District newModelQuery()
 * @method static Builder|District newQuery()
 * @method static Builder|District query()
 * @method static Builder|District whereCitycode($value)
 * @method static Builder|District whereFullname($value)
 * @method static Builder|District whereId($value)
 * @method static Builder|District whereLat($value)
 * @method static Builder|District whereLetter($value)
 * @method static Builder|District whereLevel($value)
 * @method static Builder|District whereLng($value)
 * @method static Builder|District whereName($value)
 * @method static Builder|District whereParentId($value)
 * @method static Builder|District wherePinyin($value)
 * @method static Builder|District whereSortNum($value)
 * @method static Builder|District whereZipcode($value)
 * @method static Builder|District whereZonecode($value)
 * @mixin \Eloquent
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
 * @mixin \Eloquent
 */
	class Express extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommonFeedback
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
 * @mixin \Eloquent
 */
	class Feedback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommonJPush
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $client_id
 * @property string|null $os
 * @property string|null $registerid
 * @property-read \App\Models\User|null $user
 * @method static Builder|JPush android()
 * @method static Builder|JPush ios()
 * @method static Builder|JPush newModelQuery()
 * @method static Builder|JPush newQuery()
 * @method static Builder|JPush query()
 * @method static Builder|JPush whereClientId($value)
 * @method static Builder|JPush whereId($value)
 * @method static Builder|JPush whereOs($value)
 * @method static Builder|JPush whereRegisterid($value)
 * @method static Builder|JPush whereUserId($value)
 * @mixin \Eloquent
 */
	class JPush extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommonKefu
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
 * @mixin \Eloquent
 */
	class Kefu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommonLink
 *
 * @property int $id 主键
 * @property int $cate_id 分类ID
 * @property string $type 类型
 * @property string|null $title 标题
 * @property string|null $url 链接
 * @property string $image 图片
 * @property string|null $description 描述
 * @property int $sort_num 排序
 * @property-read Link|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Link> $links
 * @property-read int|null $links_count
 * @method static Builder|Link newModelQuery()
 * @method static Builder|Link newQuery()
 * @method static Builder|Link onlyCategory()
 * @method static Builder|Link onlyLink()
 * @method static Builder|Link query()
 * @method static Builder|Link whereCateId($value)
 * @method static Builder|Link whereDescription($value)
 * @method static Builder|Link whereId($value)
 * @method static Builder|Link whereImage($value)
 * @method static Builder|Link whereSortNum($value)
 * @method static Builder|Link whereTitle($value)
 * @method static Builder|Link whereType($value)
 * @method static Builder|Link whereUrl($value)
 * @mixin \Eloquent
 */
	class Link extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommonMaterial
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $description
 * @property string $url
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
 * @method static Builder|Material filter(array $input = [], $filter = null)
 * @method static Builder|Material newModelQuery()
 * @method static Builder|Material newQuery()
 * @method static Builder|Material paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Material query()
 * @method static Builder|Material simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|Material whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Material whereCreatedAt($value)
 * @method static Builder|Material whereDescription($value)
 * @method static Builder|Material whereDownloads($value)
 * @method static Builder|Material whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Material whereExtension($value)
 * @method static Builder|Material whereHeight($value)
 * @method static Builder|Material whereId($value)
 * @method static Builder|Material whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Material whereMime($value)
 * @method static Builder|Material whereName($value)
 * @method static Builder|Material whereSize($value)
 * @method static Builder|Material whereThumb($value)
 * @method static Builder|Material whereType($value)
 * @method static Builder|Material whereUpdatedAt($value)
 * @method static Builder|Material whereUrl($value)
 * @method static Builder|Material whereUserId($value)
 * @method static Builder|Material whereViews($value)
 * @method static Builder|Material whereWidth($value)
 * @mixin \Eloquent
 */
	class Material extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommonMenu
 *
 * @property int $id 主键
 * @property string|null $name 名称
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MenuItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MenuItem> $visibleItems
 * @property-read int|null $visible_items_count
 * @method static Builder|Menu newModelQuery()
 * @method static Builder|Menu newQuery()
 * @method static Builder|Menu query()
 * @method static Builder|Menu whereId($value)
 * @method static Builder|Menu whereName($value)
 * @mixin \Eloquent
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommonMenuItem
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
 * @method static Builder|MenuItem newModelQuery()
 * @method static Builder|MenuItem newQuery()
 * @method static Builder|MenuItem query()
 * @method static Builder|MenuItem whereHide($value)
 * @method static Builder|MenuItem whereId($value)
 * @method static Builder|MenuItem whereImage($value)
 * @method static Builder|MenuItem whereMenuId($value)
 * @method static Builder|MenuItem whereParentId($value)
 * @method static Builder|MenuItem whereSortNum($value)
 * @method static Builder|MenuItem whereTarget($value)
 * @method static Builder|MenuItem whereTitle($value)
 * @method static Builder|MenuItem whereUrl($value)
 * @mixin \Eloquent
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
 * @method static Builder|DatabaseNotification read()
 * @method static Builder|DatabaseNotification unread()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Office
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $tel
 * @property string|null $email
 * @property string|null $address
 * @property int $is_head
 * @property int $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|Office newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Office newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Office query()
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereIsHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereTel($value)
 * @mixin \Eloquent
 */
	class Office extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id 页面ID
 * @property int|null $user_id 作者ID
 * @property string|null $title 标题
 * @property string|null $name 别名
 * @property string $image 图片
 * @property string|null $excerpt 摘要
 * @property string|null $content 内容
 * @property int $sort_num 显示顺序
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \Illuminate\Contracts\Routing\UrlGenerator|string $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PageMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \App\Models\User|null $user
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereContent($value)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereExcerpt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereImage($value)
 * @method static Builder|Page whereName($value)
 * @method static Builder|Page whereSortNum($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page whereUserId($value)
 * @mixin \Eloquent
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
 * @mixin \Eloquent
 */
	class PageMeta extends \Eloquent {}
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
 * @mixin \Eloquent
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
 * @mixin \Eloquent
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
 * @property int $displayorder
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereDisplayorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereIsremote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostImage whereThumb($value)
 * @mixin \Eloquent
 */
	class PostImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PostItem
 *
 * @property int $id 文章ID
 * @property int $user_id 会员ID
 * @property string|null $author 作者
 * @property string|null $format 文章格式
 * @property string|null $type 文章类型
 * @property string|null $title 文章标题
 * @property string|null $name 别名
 * @property string|null $excerpt 摘要
 * @property string $image 图片
 * @property array|null $tags 标签
 * @property int $allow_comment 允许评论
 * @property int $comment_num 评论数
 * @property int $collect_num 被收藏数
 * @property int $like_num 点赞数
 * @property int $views 浏览数
 * @property string|null $from 来源
 * @property string|null $fromurl 来源地址
 * @property float $price 阅读价格
 * @property int $click1
 * @property int $click2
 * @property int $click3
 * @property int $click4
 * @property int $click5
 * @property int $click6
 * @property int $click7
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
 * @property-read mixed $format_des
 * @property-read mixed $status_des
 * @property-read \Illuminate\Contracts\Routing\UrlGenerator|string $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostLog> $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \App\Models\User|null $user
 * @method static Builder|Post filter(array $input = [], $filter = null)
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Post query()
 * @method static Builder|Post simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|Post whereAllowComment($value)
 * @method static Builder|Post whereAuthor($value)
 * @method static Builder|Post whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Post whereClick1($value)
 * @method static Builder|Post whereClick2($value)
 * @method static Builder|Post whereClick3($value)
 * @method static Builder|Post whereClick4($value)
 * @method static Builder|Post whereClick5($value)
 * @method static Builder|Post whereClick6($value)
 * @method static Builder|Post whereClick7($value)
 * @method static Builder|Post whereCollectNum($value)
 * @method static Builder|Post whereCommentNum($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Post whereExcerpt($value)
 * @method static Builder|Post whereFormat($value)
 * @method static Builder|Post whereFrom($value)
 * @method static Builder|Post whereFromurl($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereImage($value)
 * @method static Builder|Post whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Post whereLikeNum($value)
 * @method static Builder|Post whereName($value)
 * @method static Builder|Post wherePrice($value)
 * @method static Builder|Post whereStatus($value)
 * @method static Builder|Post whereTags($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereType($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post whereUserId($value)
 * @method static Builder|Post whereViews($value)
 * @mixin \Eloquent
 */
	class PostItem extends \Eloquent {}
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
 * @mixin \Eloquent
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
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta wherePostId($value)
 * @mixin \Eloquent
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
 * @mixin \Eloquent
 */
	class PostTag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Property
 *
 * @property int $id 主键
 * @property int $user_id 作者
 * @property string|null $title 物业名称
 * @property string $image 封面图
 * @property string|null $description 摘要
 * @property float $price 价格
 * @property string|null $type 类型
 * @property string|null $country 国家
 * @property string|null $state 州
 * @property string|null $city 城市
 * @property string|null $addressline 详细地址
 * @property float $lng 经度
 * @property float $lat 纬度
 * @property int $property_type_id 物业类型
 * @property string|null $unit_number
 * @property float $unit_size
 * @property int $bedrooms
 * @property int $bathrooms
 * @property int $views
 * @property string|null $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyFeature> $features
 * @property-read int|null $features_count
 * @property-read mixed $status_des
 * @property-read mixed $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RealEstatePropertyImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RealEstatePropertyMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RealEstatePropertyVideo> $videos
 * @property-read int|null $videos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Property filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Property paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder|Property simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereAddressline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property wherePropertyTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereUnitNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereUnitSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Property whereViews($value)
 * @mixin \Eloquent
 * @property-read \App\Models\PropertyType|null $propertyType
 */
	class Property extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PropertyFeature
 *
 * @property int $id
 * @property string|null $name
 * @property int $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFeature query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFeature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFeature whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyFeature whereSortNum($value)
 * @mixin \Eloquent
 */
	class PropertyFeature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PropertyImage
 *
 * @property int $id
 * @property int $property_id
 * @property string|null $url
 * @property int|null $sort_num
 * @method static Builder|RealEstatePropertyImage newModelQuery()
 * @method static Builder|RealEstatePropertyImage newQuery()
 * @method static Builder|RealEstatePropertyImage query()
 * @method static Builder|RealEstatePropertyImage whereId($value)
 * @method static Builder|RealEstatePropertyImage wherePropertyId($value)
 * @method static Builder|RealEstatePropertyImage whereSortNum($value)
 * @method static Builder|RealEstatePropertyImage whereUrl($value)
 * @mixin \Eloquent
 */
	class PropertyImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PropertyMeta
 *
 * @property int $meta_id
 * @property int $property_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|RealEstatePropertyMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RealEstatePropertyMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RealEstatePropertyMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|RealEstatePropertyMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealEstatePropertyMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealEstatePropertyMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RealEstatePropertyMeta wherePropertyId($value)
 * @mixin \Eloquent
 */
	class PropertyMeta extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PropertyType
 *
 * @property int $id
 * @property int $parent_id
 * @property string|null $name
 * @property string|null $slug
 * @property int $sort_num
 * @property-read \Illuminate\Database\Eloquent\Collection<int, PropertyType> $childs
 * @property-read int|null $childs_count
 * @property-read PropertyType|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, PropertyType> $siblings
 * @property-read int|null $siblings_count
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType query()
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PropertyType whereSortNum($value)
 * @mixin \Eloquent
 */
	class PropertyType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PropertyVideo
 *
 * @property int $id
 * @property int $property_id
 * @property string|null $url
 * @property int|null $sort_num
 * @method static Builder|RealEstatePropertyVideo newModelQuery()
 * @method static Builder|RealEstatePropertyVideo newQuery()
 * @method static Builder|RealEstatePropertyVideo query()
 * @method static Builder|RealEstatePropertyVideo whereId($value)
 * @method static Builder|RealEstatePropertyVideo wherePropertyId($value)
 * @method static Builder|RealEstatePropertyVideo whereSortNum($value)
 * @method static Builder|RealEstatePropertyVideo whereUrl($value)
 * @mixin \Eloquent
 */
	class PropertyVideo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Region
 *
 * @property int $id
 * @property int $parent_id
 * @property string|null $name
 * @property string|null $short_name
 * @property int $sort_num
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Region> $childs
 * @property-read int|null $childs_count
 * @property-read Region|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Region> $siblings
 * @property-read int|null $siblings_count
 * @method static Builder|Region newModelQuery()
 * @method static Builder|Region newQuery()
 * @method static Builder|Region query()
 * @method static Builder|Region whereId($value)
 * @method static Builder|Region whereName($value)
 * @method static Builder|Region whereParentId($value)
 * @method static Builder|Region whereShortName($value)
 * @method static Builder|Region whereSortNum($value)
 * @mixin \Eloquent
 * @property string|null $type 类型
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereType($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RegionCity
 *
 * @property int $id
 * @property int|null $country_id
 * @property int|null $state_id
 * @property string|null $name
 * @property string|null $short_name
 * @property int|null $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|RegionCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegionCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RegionCity query()
 * @method static \Illuminate\Database\Eloquent\Builder|RegionCity whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegionCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegionCity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegionCity whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegionCity whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RegionCity whereStateId($value)
 */
	class RegionCity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommonSetting
 *
 * @property string $skey 标识
 * @property string|null $svalue 值
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSkey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSvalue($value)
 * @mixin \Eloquent
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shortcut
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $content
 * @property int|null $sort_num
 * @method static Builder|Shortcut newModelQuery()
 * @method static Builder|Shortcut newQuery()
 * @method static Builder|Shortcut query()
 * @method static Builder|Shortcut whereContent($value)
 * @method static Builder|Shortcut whereId($value)
 * @method static Builder|Shortcut whereSortNum($value)
 * @method static Builder|Shortcut whereType($value)
 * @mixin \Eloquent
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
 * @mixin \Eloquent
 */
	class Snippet extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $uid 主键
 * @property int $gid 管理权限
 * @property string|null $nickname 昵称
 * @property string|null $phone 手机号
 * @property string|null $email 邮箱
 * @property string|null $avatar 头像
 * @property int $credits 积分
 * @property string|null $password 密码
 * @property string|null $remember_token
 * @property int $freeze 冻结
 * @property float $latitude 纬度
 * @property float $longitude 经度
 * @property int $email_status 邮箱验证状态
 * @property int $name_status 实名认证状态
 * @property int $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\UserAccount|null $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserAddress> $addresses
 * @property-read int|null $addresses_count
 * @property-read \App\Models\UserCertify|null $certify
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $collectedPosts
 * @property-read int|null $collected_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserConnect> $connects
 * @property-read int|null $connects_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNameStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Account
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
 * @mixin \Eloquent
 */
	class UserAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Address
 *
 * @property int $id 主键
 * @property int $user_id 用户ID
 * @property string|null $tag 标签
 * @property string|null $name 姓名
 * @property string|null $phone 电话
 * @property string|null $province 省
 * @property string|null $city 市
 * @property string|null $district 区县
 * @property string|null $street 详细地址
 * @property float $latitude 纬度
 * @property float $longitude 经度
 * @property string|null $postalcode 邮编
 * @property int $isdefault 是否默认地址
 * @property-read string $formatted_address
 * @property-read \App\Models\User|null $user
 * @method static Builder|UserAddress newModelQuery()
 * @method static Builder|UserAddress newQuery()
 * @method static Builder|UserAddress query()
 * @method static Builder|UserAddress whereCity($value)
 * @method static Builder|UserAddress whereDistrict($value)
 * @method static Builder|UserAddress whereId($value)
 * @method static Builder|UserAddress whereIsdefault($value)
 * @method static Builder|UserAddress whereLatitude($value)
 * @method static Builder|UserAddress whereLongitude($value)
 * @method static Builder|UserAddress whereName($value)
 * @method static Builder|UserAddress wherePhone($value)
 * @method static Builder|UserAddress wherePostalcode($value)
 * @method static Builder|UserAddress whereProvince($value)
 * @method static Builder|UserAddress whereStreet($value)
 * @method static Builder|UserAddress whereTag($value)
 * @method static Builder|UserAddress whereUserId($value)
 * @mixin \Eloquent
 */
	class UserAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAuth
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
 * @mixin \Eloquent
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
 * @property string|null $unionid UnionID
 * @property string|null $openid 开放ID
 * @property string|null $nickname 昵称
 * @property int $gender 性别
 * @property string|null $city 城市
 * @property string|null $province 省，州
 * @property string|null $country 国籍
 * @property string|null $avatar 头像地址
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\User|null $user
 * @method static Builder|UserConnect newModelQuery()
 * @method static Builder|UserConnect newQuery()
 * @method static Builder|UserConnect query()
 * @method static Builder|UserConnect whereAppid($value)
 * @method static Builder|UserConnect whereAvatar($value)
 * @method static Builder|UserConnect whereCity($value)
 * @method static Builder|UserConnect whereCountry($value)
 * @method static Builder|UserConnect whereCreatedAt($value)
 * @method static Builder|UserConnect whereGender($value)
 * @method static Builder|UserConnect whereId($value)
 * @method static Builder|UserConnect whereNickname($value)
 * @method static Builder|UserConnect whereOpenid($value)
 * @method static Builder|UserConnect wherePlatform($value)
 * @method static Builder|UserConnect whereProvince($value)
 * @method static Builder|UserConnect whereUnionid($value)
 * @method static Builder|UserConnect whereUpdatedAt($value)
 * @method static Builder|UserConnect whereUserId($value)
 * @mixin \Eloquent
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
 * @mixin \Eloquent
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
 * @method static Builder|UserGroup newModelQuery()
 * @method static Builder|UserGroup newQuery()
 * @method static Builder|UserGroup query()
 * @method static Builder|UserGroup whereCredits($value)
 * @method static Builder|UserGroup whereGid($value)
 * @method static Builder|UserGroup whereMemo($value)
 * @method static Builder|UserGroup whereName($value)
 * @method static Builder|UserGroup wherePrivileges($value)
 * @mixin \Eloquent
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
 * @mixin \Eloquent
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
 * @mixin \Eloquent
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
 * @property string|null $prepay_id 微信支付prepay_id
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
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay wherePrepayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPrepay whereUserId($value)
 * @mixin \Eloquent
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
 * @mixin \Eloquent
 */
	class UserTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Verify
 *
 * @property int $id
 * @property string|null $code 验证码
 * @property string|null $phone 手机号
 * @property string|null $email 邮箱
 * @property int $used 已使用
 * @property \Illuminate\Support\Carbon|null $created_at 发送时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserVerify whereUsed($value)
 * @mixin \Eloquent
 */
	class UserVerify extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WxLogin
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
 * @mixin \Eloquent
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
 * @method static Builder|WechatMenu newModelQuery()
 * @method static Builder|WechatMenu newQuery()
 * @method static Builder|WechatMenu query()
 * @method static Builder|WechatMenu whereAppid($value)
 * @method static Builder|WechatMenu whereId($value)
 * @method static Builder|WechatMenu whereKey($value)
 * @method static Builder|WechatMenu whereMediaId($value)
 * @method static Builder|WechatMenu whereName($value)
 * @method static Builder|WechatMenu wherePagepath($value)
 * @method static Builder|WechatMenu whereParentId($value)
 * @method static Builder|WechatMenu whereSortNum($value)
 * @method static Builder|WechatMenu whereType($value)
 * @method static Builder|WechatMenu whereUrl($value)
 * @mixin \Eloquent
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
 * @mixin \Eloquent
 */
	class WechatSession extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WpTerms
 *
 * @method static \Illuminate\Database\Eloquent\Builder|WpTerms newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WpTerms newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WpTerms query()
 * @mixin \Eloquent
 */
	class WpTerms extends \Eloquent {}
}


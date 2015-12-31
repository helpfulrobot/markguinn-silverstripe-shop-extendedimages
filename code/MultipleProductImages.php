<?php
/**
 * Based on the recipe in the recipe for Multiple images in
 * the docs.
 *
 * @author Mark Guinn <mark@adaircreative.com>
 * @date 08.20.2013
 * @package shop_extendedimages
 */
class MultipleProductImages extends DataExtension
{
    private static $many_many = array(
        'AdditionalImages' => 'Image',
    );

    private static $many_many_extraFields = array(
        'AdditionalImages' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Images', array(
            new SortableUploadField('AdditionalImages', _t('SHOPEXTENDEDIMAGES.AdditionImages', 'Additional Images')),
            new LiteralField('additionalimagesinstructions', '<p>' . _t('SHOPEXTENDEDIMAGES.Instructions', 'You can change the order of the Additional Images by clicking and dragging on the image thumbnail.') . '</p>'),
        ));
    }

    /**
     * Combines the main image and the secondary images
     * @return ArrayList
     */
    public function AllImages()
    {
        $list = new ArrayList($this->owner->AdditionalImages()->sort('SortOrder')->toArray());
        $main = $this->owner->Image();
        if ($main && $main->exists()) {
            $list->unshift($main);
        }
        return $list;
    }

    /**
     * @return DataList
     */
    public function SortedAdditionalImages()
    {
        $list = $this->owner->AdditionalImages()->sort('SortOrder');
        return $list;
    }
}

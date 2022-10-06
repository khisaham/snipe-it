<?php

namespace App\Presenters;

/**
 * Class CompanyPresenter
 */
class TagPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => 'IMEI',
                'visible' => true,
                'formatter' => 'companiesLinkFormatter',
            ], [
                'field' => 'image',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => 'TYPE',
                'visible' => true,
                'formatter' => 'imageFormatter',
            ], [
                'field' => 'users_count',
                'searchable' => false,
                'sortable' => true,
                'title' => 'STATUS',
                'visible' => true,

            ], [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'visible' => true,
                'formatter' => 'companiesActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Link to this companies name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('tag.show', $this->imei, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('tag.show', $this->id);
    }
}
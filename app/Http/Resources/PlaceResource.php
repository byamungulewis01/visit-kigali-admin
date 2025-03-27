<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'price' => $this->price,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'image' => $this->image,
            'rating' => $this->rating,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'reviews' => $this->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'tourist_id' => $review->tourist_id,
                    'content' => $review->content,
                    'is_top_rated' => $review->is_top_rated,
                    'place_id' => $review->place_id,
                    'created_at' => $review->created_at,
                    'updated_at' => $review->updated_at,
                    'rating' => $review->rating,
                    'name' => $review->tourist->fname . ' ' . $review->tourist->lname
                ];
            }),
        ];
    }
}

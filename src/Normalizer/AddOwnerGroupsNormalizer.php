<?php

namespace App\Normalizer;

use App\Entity\DragonTreasure;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsDecorator('api_platform.jsonld.normalizer.item')]
class AddOwnerGroupsNormalizer implements NormalizerInterface, SerializerAwareInterface {
	public function __construct(
		private NormalizerInterface $normalizer,
		private Security $security
	){

	}

	public function normalize(mixed $object, string $format = null, array $context = []): array|\ArrayObject|bool|float|int|null|string {
		if ($object instanceof DragonTreasure && $this->security->getUser() === $object->getOwner()) {
			$context['groups'][] = 'owner:read';
		};

		return $this->normalizer->normalize($object, $format, $context);
	}

	public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool {
		return $this->normalizer->supportsNormalization($data, $format, $context);
	}

	public function setSerializer(SerializerInterface $serializer) {
		if ($this->normalizer instanceof SerializerAwareInterface) {
			$this->normalizer->setSerializer($serializer);
		}
	}

}
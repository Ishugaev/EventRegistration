<?php

namespace EventRegistration\Manager;

use EventRegistration\Exception\RegistrationManagerException;
use Spot\Locator;
use EventRegistration\Entity\User;
use EventRegistration\Entity\Voucher;
use Psr\Log\LoggerInterface;

class RegistrationRequestManager implements RequestManagerInterface
{
    /**
     * @var Locator $spot
     */
    private $spot;

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    public function __construct(Locator $spot, LoggerInterface $logger)
    {
        $this->spot = $spot;
        $this->logger = $logger;
    }

    /**
     * @param array $requestData
     * @return Voucher
     * @throws RegistrationManagerException
     */
    public function manage(array $requestData): Voucher
    {
        $voucherRepo = $this->spot->mapper(Voucher::class);
        $userRepo = $this->spot->mapper(User::class);
        try {
            $userRepo->connection()->beginTransaction();

            $dataToPersist = [];
            foreach ($requestData as $key => $value) {
                if ($userRepo->fieldExists($key)) {
                    $dataToPersist = array_merge($dataToPersist, [$key => $value]);
                }
            }

            $user = $userRepo->create($dataToPersist);

            $voucher = $voucherRepo->create([
                'user_id' => $user->id,
                'voucher' => $this->generateVoucherCode()
            ]);

            $userRepo->connection()->commit();

            return $voucher;
        } catch (\Exception $e) {
            $userRepo->connection()->rollback();
            $this->logger->error($e);
            throw new RegistrationManagerException($e->getMessage());
        }
    }

    /**
     * Generates unique voucher code
     * @return string
     */
    private function generateVoucherCode(): string
    {
        return implode('-', str_split(sha1(uniqid().(new \DateTime())->format('Y-m-d H:i:s')), 4));
    }
}

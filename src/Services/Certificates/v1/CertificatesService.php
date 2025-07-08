<?php

namespace GoDaddy\Services\Certificates\v1;

use GoDaddy\Services\Certificates\v1\DTO\CertificateCreateData;
use GoDaddy\Services\Certificates\v1\DTO\CertificateReissueData;
use GoDaddy\Services\BaseService;
use GoDaddy\Services\Certificates\v1\DTO\CertificateRenewData;
use GoDaddy\Services\Certificates\v1\DTO\CertificateRevokeData;
use GoDaddy\Services\Certificates\v1\Exceptions\{
    CertificateCreationException,
    CertificateValidationException,
    CertificateDetailsFetchException,
    CertificateActionsFetchException,
    CertificateEmailResendException,
    CertificateAlternateEmailException,
    CertificateEmailSpecificResendException,
    CertificateEmailHistoryFetchException,
    CertificateCallbackUnregisterException,
    CertificateCallbackFetchException,
    CertificateCallbackRegisterException,
    CertificateCancelException,
    CertificateDownloadException,
    CertificateReissueException
};
use GoDaddy\Services\Certificates\v1\Exceptions\CertificateRenewException;
use GoDaddy\Services\Certificates\v1\Exceptions\CertificateRevokeException;
use GoDaddy\Services\Certificates\v1\Exceptions\CertificateSiteSealFetchException;
use GoDaddy\Services\Certificates\v1\Exceptions\CertificateVerifyDomainException;
use GoDaddy\Support\ErrorCode;
use GuzzleHttp\Exception\ClientException;

class CertificatesService extends BaseService
{
    public function createCertificate(CertificateCreateData $data): array
    {
        try {
            $response = $this->client->post('/v1/certificates', [
                'json' => $data->toArray(),
            ]);
            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateCreationException::class, ErrorCode::CERTIFICATE_CREATION_FAILED);
        }
    }

    public function validateCertificate(CertificateCreateData $data): array
    {
        try {
            $response = $this->client->post('/v1/certificates/validate', [
                'json' => $data->toArray(),
            ]);
            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateValidationException::class, ErrorCode::CERTIFICATE_VALIDATION_FAILED);
        }
    }

    public function getCertificate(string $certificateId): array
    {
        try {
            $response = $this->client->get("/v1/certificates/{$certificateId}");
            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateDetailsFetchException::class, ErrorCode::CERTIFICATE_DETAILS_FETCH_FAILED);
        }
    }

    public function getCertificateActions(string $certificateId): array
    {
        try {
            $response = $this->client->get("/v1/certificates/{$certificateId}/actions");
            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateActionsFetchException::class, ErrorCode::CERTIFICATE_ACTIONS_FETCH_FAILED);
        }
    }

    public function resendEmail(string $certificateId, string $emailId): void
    {
        try {
            $this->client->post("/v1/certificates/{$certificateId}/email/{$emailId}/resend");
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateEmailResendException::class, ErrorCode::CERTIFICATE_EMAIL_RESEND_FAILED);
        }
    }

    public function resendAllToAlternateEmail(string $certificateId, string $emailAddress): void
    {
        try {
            $this->client->post("/v1/certificates/{$certificateId}/email/resend/{$emailAddress}");
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateAlternateEmailException::class, ErrorCode::CERTIFICATE_EMAIL_ALT_RESEND_FAILED);
        }
    }

    public function resendEmailToSpecificAddress(string $certificateId, string $emailId, string $emailAddress): void
    {
        try {
            $this->client->post("/v1/certificates/{$certificateId}/email/{$emailId}/resend/{$emailAddress}");
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateEmailSpecificResendException::class, ErrorCode::CERTIFICATE_EMAIL_SPECIFIC_RESEND_FAILED);
        }
    }

    public function getEmailHistory(string $certificateId): array
    {
        try {
            $response = $this->client->get("/v1/certificates/{$certificateId}/email/history");
            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateEmailHistoryFetchException::class, ErrorCode::CERTIFICATE_EMAIL_HISTORY_FETCH_FAILED);
        }
    }

    public function unregisterCallback(string $certificateId): void
    {
        try {
            $this->client->delete("/v1/certificates/{$certificateId}/callback");
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateCallbackUnregisterException::class, ErrorCode::CERTIFICATE_CALLBACK_UNREGISTER_FAILED);
        }
    }

    public function getCallback(string $certificateId): array
    {
        try {
            $response = $this->client->get("/v1/certificates/{$certificateId}/callback");
            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateCallbackFetchException::class, ErrorCode::CERTIFICATE_CALLBACK_FETCH_FAILED);
        }
    }

    public function registerCallback(string $certificateId, string $callbackUrl): void
    {
        try {
            $this->client->put("/v1/certificates/{$certificateId}/callback", [
                'query' => ['callbackUrl' => $callbackUrl],
            ]);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateCallbackRegisterException::class, ErrorCode::CERTIFICATE_CALLBACK_REGISTER_FAILED);
        }
    }

    public function cancelCertificate(string $certificateId): void
    {
        try {
            $this->client->post("/v1/certificates/{$certificateId}/cancel");
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateCancelException::class, ErrorCode::CERTIFICATE_CANCEL_FAILED);
        }
    }

    public function downloadCertificate(string $certificateId): string
    {
        try {
            $response = $this->client->get("/v1/certificates/{$certificateId}/download");
            return $response->getBody()->getContents();
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateDownloadException::class, ErrorCode::CERTIFICATE_DOWNLOAD_FAILED);
        }
    }

    public function reissueCertificate(string $certificateId, CertificateReissueData $data): array
    {
        try {
            $response = $this->client->post("/v1/certificates/{$certificateId}/reissue", [
                'json' => $data->toArray(),
            ]);
            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateReissueException::class, ErrorCode::CERTIFICATE_REISSUE_FAILED);
        }
    }

    public function renewCertificate(string $certificateId, CertificateRenewData $data): array
    {
        try {
            $response = $this->client->post("/v1/certificates/{$certificateId}/renew", [
                'json' => $data->toArray(),
            ]);
            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateRenewException::class, ErrorCode::CERTIFICATE_RENEW_FAILED);
        }
    }

    public function revokeCertificate(string $certificateId, CertificateRevokeData $data): void
    {
        try {
            $this->client->post("/v1/certificates/{$certificateId}/revoke", [
                'json' => $data->toArray(),
            ]);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateRevokeException::class, ErrorCode::CERTIFICATE_REVOKE_FAILED);
        }
    }

    public function getSiteSeal(string $certificateId, string $theme = 'LIGHT', string $locale = 'en'): array
    {
        try {
            $response = $this->client->get("/v1/certificates/{$certificateId}/siteSeal", [
                'query' => [
                    'theme' => $theme,
                    'locale' => $locale,
                ],
            ]);
            return $this->decodeResponse($response);
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateSiteSealFetchException::class, ErrorCode::CERTIFICATE_SITE_SEAL_FETCH_FAILED);
        }
    }

    public function verifyDomainControl(string $certificateId): void
    {
        try {
            $this->client->post("/v1/certificates/{$certificateId}/verifyDomainControl");
        } catch (ClientException $e) {
            $this->handleHttpException($e, CertificateVerifyDomainException::class, ErrorCode::CERTIFICATE_VERIFY_DOMAIN_FAILED);
        }
    }

}
